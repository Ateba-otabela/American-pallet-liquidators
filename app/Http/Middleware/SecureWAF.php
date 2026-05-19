<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureWAF
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isMalicious($request)) {
            // Log the security breach attempt
            \Illuminate\Support\Facades\Log::warning('🚨 SECURITY SHIELD WAF BLOCK: Suspicious request intercepted!', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_agent' => $request->header('User-Agent'),
                'inputs' => $request->all()
            ]);

            // Render a beautiful, premium "Threat Intercepted" Enterprise-level block page
            return new Response($this->getSecurityBlockHtml($request), 403, ['Content-Type' => 'text/html']);
        }

        return $next($request);
    }

    /**
     * Detect if request contains malicious signatures (WAF Rules).
     */
    protected function isMalicious(Request $request): bool
    {
        $ua = $request->header('User-Agent', '');
        $path = $request->path();
        
        // 1. Check User-Agent Header for Scanner Bots & Shellshock exploits
        $maliciousUA = [
            '/sqlmap/i', '/nikto/i', '/acunetix/i', '/dirbuster/i', '/nmap/i', 
            '/hydra/i', '/metasploit/i', '/censys/i', '/shodan/i', '/netsparker/i',
            '/\(\)\s*\{\s*:\s*;\s*\}\s*/' // Shellshock Bash exploit signature
        ];
        foreach ($maliciousUA as $pattern) {
            if (preg_match($pattern, $ua)) {
                return true;
            }
        }

        // 2. Check URI Path for Traversal & Remote File Inclusions (LFI/RFI)
        $maliciousPaths = [
            '/\.\.\//', '/\.\.\\\\/', // Traversal (../../ or ..\\)
            '/etc\/(passwd|shadow|group|hosts)/i', // System files
            '/(boot|win)\.ini/i', // Windows system files
            '/php:\/\/(input|filter)/i', // PHP wrappers
            '/\.env/i', '/\.git/i', // Hardened configuration scanner protection
            '/wp-(login|config|admin|content)/i', // Block typical WordPress scanner bots
            '/xanger/i', '/composer\.json/i', '/package\.json/i'
        ];
        foreach ($maliciousPaths as $pattern) {
            if (preg_match($pattern, $path)) {
                return true;
            }
        }

        // 3. Scan Request Payload (GET & POST params recursively)
        $inputs = $request->all();
        if ($this->scanPayloadRecursive($inputs)) {
            return true;
        }

        return false;
    }

    /**
     * Recursively scan request values for security threats.
     */
    protected function scanPayloadRecursive(array $payload): bool
    {
        foreach ($payload as $key => $value) {
            if (is_array($value)) {
                if ($this->scanPayloadRecursive($value)) {
                    return true;
                }
            } else {
                if ($this->isMaliciousString((string) $value)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Regex scanning logic for SQLi, XSS, RCE, and Command Injection.
     */
    protected function isMaliciousString(string $input): bool
    {
        if (empty($input)) {
            return false;
        }

        $patterns = [
            // A. SQL Injection (SQLi) Rules
            '/\b(union|select|insert|update|delete|drop|alter|truncate)\b.*\b(from|where|into|table|database)\b/is', // UNION SELECT / SELECT FROM combo
            '/[\'"]\s*or\s*[\'"]?\d+[\'"]?\s*=\s*[\'"]?\d+/i', // ' or 1=1 logic bypass
            '/[\'"]\s*and\s*[\'"]?\d+[\'"]?\s*=\s*[\'"]?\d+/i', // ' and 1=1
            '/\b(union\s+all\s+select|select\s+count\(\*\))\b/i',
            '/[\'"]\s*union\s+select/i',
            '/--;|--\s*$/i', // SQL comments
            
            // B. Cross-Site Scripting (XSS) Rules
            '/(<|%3C)\s*script/i', // <script> tag
            '/javascript\s*:/i', // javascript: URI schemes
            '/\bon(load|error|click|mouseover|focus|submit|change|keydown|keyup)\b\s*=/i', // onload=, onerror= DOM hooks
            '/(<|%3C)iframe/i', // iframes insertion
            '/document\.(cookie|write|location)/i', // cookie stealing attempts
            '/(<|%3C)img.*src.*javascript/i',
            
            // C. Remote Code Execution (RCE) / System Commands Rules
            '/\b(exec|shell_exec|system|passthru|eval|base64_decode|popen|proc_open)\b\s*\(/i', // dangerous PHP commands
            '/(\b(ping|curl|wget|nc|bash|sh|powershell|cmd)\b.*[;&|<>])/is', // command injection delimiters
            '/\b(cat|grep|tail|head)\b.*\b(etc|passwd|shadow)/is', // dumping credentials exploits
            '/phpinfo\s*\(\s*\)/i'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Custom Enterprise Security Shield HTML template.
     */
    protected function getSecurityBlockHtml(Request $request): string
    {
        $ip = $request->ip();
        $time = now()->setTimezone('America/New_York')->format('M d, Y - h:i:s A') . ' EST';
        $ref = strtoupper(bin2hex(random_bytes(6)));

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚨 Threat Blocked by Security WAF Shield</title>
    <style>
        body { font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background-color: #0c0a09; color: #f5f5f4; height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; padding: 20px; box-sizing: border-box; }
        .card { max-width: 550px; width: 100%; background: #1c1917; border: 1px solid #ef4444; border-radius: 12px; padding: 40px; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.1); text-align: center; }
        .icon { background-color: rgba(239, 68, 68, 0.1); border-radius: 50%; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; border: 1px solid rgba(239, 68, 68, 0.3); }
        .icon svg { width: 35px; height: 35px; color: #ef4444; }
        h1 { font-size: 24px; font-weight: 900; margin: 0 0 10px; text-transform: uppercase; letter-spacing: 1px; color: #ffffff; }
        p { font-size: 14px; line-height: 1.6; color: #a8a29e; margin: 0 0 25px; }
        .meta-box { background-color: #141210; border-radius: 8px; padding: 15px 20px; border: 1px solid #2e2a24; text-align: left; margin-bottom: 25px; }
        .meta-line { font-size: 12px; font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; color: #d6d3d1; margin-bottom: 6px; }
        .meta-line:last-child { margin-bottom: 0; }
        .meta-line strong { color: #ef4444; font-weight: bold; }
        .footer { font-size: 11px; color: #78716c; letter-spacing: 0.5px; text-transform: uppercase; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h1>Threat Intercepted</h1>
        <p>Your request has been flagged as a malicious security violation (SQL Injection, XSS, or Command Injection) and was terminated instantly by our Web Application Firewall (WAF) Shield.</p>
        
        <div class="meta-box">
            <div class="meta-line"><strong>STATUS:</strong> BLOCKED (403 FORBIDDEN)</div>
            <div class="meta-line"><strong>IP ADDRESS:</strong> {$ip}</div>
            <div class="meta-line"><strong>TIMESTAMP:</strong> {$time}</div>
            <div class="meta-line"><strong>INCIDENT ID:</strong> APL-{$ref}</div>
        </div>
        
        <div class="footer">
            Enterprise WAF Protection &bull; American Pallet Liquidators
        </div>
    </div>
</body>
</html>
HTML;
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        
        // Exclude admin pages, debugbar, storage, and static assets from logs
        if ($request->is('admin*') || 
            $request->is('_debugbar*') || 
            $request->is('livewire*') ||
            $request->is('storage*') ||
            preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|eot)$/i', $path)
        ) {
            return $next($request);
        }

        $ua = $request->header('User-Agent');
        $ip = $request->ip();

        // 1. Parse OS
        $os = 'Unknown OS';
        $osArray = [
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/ipad/i'               =>  'iPadOS (iPad)',
            '/iphone/i'             =>  'iOS (iPhone)',
            '/ipod/i'               =>  'iOS (iPod)',
            '/android/i'            =>  'Android',
            '/macintosh|mac os x/i' =>  'macOS',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
        ];
        foreach ($osArray as $regex => $value) {
            if (preg_match($regex, $ua)) {
                $os = $value;
                break;
            }
        }

        // 2. Parse Browser
        $browser = 'Unknown Browser';
        $browserArray = [
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        ];
        foreach ($browserArray as $regex => $value) {
            if (preg_match($regex, $ua)) {
                $browser = $value;
                break;
            }
        }
        
        if (preg_match('/chrome/i', $ua) && preg_match('/safari/i', $ua)) {
            $browser = 'Chrome';
        }
        if (preg_match('/edge|edg/i', $ua)) {
            $browser = 'Edge';
        }

        // 3. Parse Device Type & Details
        $deviceType = 'Desktop';
        if (preg_match('/tablet|ipad|playbook|silk/i', $ua)) {
            $deviceType = 'Tablet';
        } elseif (preg_match('/mobile|phone|iphone|ipod|blackberry|opera mini|iemobile/i', $ua)) {
            $deviceType = 'Mobile';
        }

        $deviceDetails = 'Desktop';
        if ($deviceType === 'Mobile') {
            if (preg_match('/iphone/i', $ua)) {
                $deviceDetails = 'Apple iPhone';
            } elseif (preg_match('/android.*mobile/i', $ua)) {
                if (preg_match('/android\s+([a-zA-Z0-9\-\s\_]+);/i', $ua, $matches)) {
                    $deviceDetails = 'Android (' . trim($matches[1]) . ')';
                } else {
                    $deviceDetails = 'Android Mobile Phone';
                }
            } else {
                $deviceDetails = 'Mobile Phone';
            }
        } elseif ($deviceType === 'Tablet') {
            if (preg_match('/ipad/i', $ua)) {
                $deviceDetails = 'Apple iPad';
            } else {
                $deviceDetails = 'Tablet Device';
            }
        } else {
            if (preg_match('/macintosh/i', $ua)) {
                $deviceDetails = 'Macintosh PC';
            } elseif (preg_match('/windows/i', $ua)) {
                $deviceDetails = 'Windows PC';
            } else {
                $deviceDetails = 'Linux PC / Desktop';
            }
        }

        // 4. Resolve Geolocation
        $isLocal = false;
        if ($ip === '127.0.0.1' || $ip === '::1' || empty($ip)) {
            $isLocal = true;
        } else {
            // Detect private/local IP address ranges (192.168.x.x, 10.x.x.x, 172.16.x.x to 172.31.x.x)
            $privateIPPatterns = [
                '/^10\./',
                '/^172\.(1[6-9]|2[0-9]|3[0-1])\./',
                '/^192\.168\./'
            ];
            foreach ($privateIPPatterns as $pattern) {
                if (preg_match($pattern, $ip)) {
                    $isLocal = true;
                    break;
                }
            }
        }

        $location = 'Local Network / Localhost';
        if (!$isLocal) {
            try {
                $ctx = stream_context_create(['http' => ['timeout' => 2]]);
                $response = file_get_contents("http://ip-api.com/json/{$ip}", false, $ctx);
                if ($response) {
                    $data = json_decode($response, true);
                    if ($data && $data['status'] === 'success') {
                        $location = $data['city'] . ', ' . $data['regionName'] . ' (' . $data['countryCode'] . ')';
                    } else {
                        $location = 'Unknown Location';
                    }
                }
            } catch (\Exception $e) {
                $location = 'Unknown Location';
            }
        }

        // 5. Store visit log in database
        try {
            \App\Models\VisitLog::create([
                'ip_address' => $ip,
                'user_agent' => $deviceDetails, // Storing extracted device name for premium layout!
                'device_type' => $deviceType,
                'os' => $os,
                'browser' => $browser,
                'path' => '/' . $path,
                'location' => $location
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to save visit log: ' . $e->getMessage());
        }

        return $next($request);
    }
}

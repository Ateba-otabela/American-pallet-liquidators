@extends('layouts.admin')

@section('title', 'Chat with ' . ($conversation->customer_name ?? 'Guest'))

@section('admin_content')
    <div class="space-y-6 max-w-4xl mx-auto h-[80vh] flex flex-col">
        
        <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm border border-gray-200 shrink-0">
            <div>
                <h2 class="text-lg font-extrabold text-zinc-950 uppercase tracking-tight flex items-center gap-2">
                    {{ $conversation->customer_name ?? 'Guest' }}
                    @if($conversation->needs_admin)
                        <span class="bg-red-100 text-red-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">Needs Attention</span>
                    @endif
                </h2>
                <span class="text-xs text-zinc-500 font-semibold">{{ $conversation->customer_email ?? 'No email provided' }}</span>
            </div>
            <div class="flex gap-2">
                @if($conversation->ai_active)
                    <form action="{{ route('admin.support.takeOver', $conversation) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-rose-600 text-white px-4 py-2 rounded text-xs font-black uppercase tracking-wider hover:bg-rose-700 transition">Pause AI & Take Over</button>
                    </form>
                @else
                    <form action="{{ route('admin.support.resumeAi', $conversation) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded text-xs font-black uppercase tracking-wider hover:bg-emerald-700 transition">Resume AI</button>
                    </form>
                @endif
                <a href="{{ route('admin.support.index') }}" class="bg-gray-100 text-zinc-800 px-4 py-2 rounded text-xs font-black uppercase tracking-wider hover:bg-gray-200 transition">Back</a>
            </div>
        </div>

        <!-- Chat History -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm flex-grow overflow-y-auto p-6 space-y-4 flex flex-col" id="chatWindow">
            @foreach($conversation->messages()->oldest()->get() as $msg)
                @if($msg->sender_type === 'customer')
                    <div class="flex justify-start">
                        <div class="bg-gray-100 text-zinc-800 rounded-2xl rounded-tl-sm px-4 py-2 max-w-[80%] text-sm shadow-sm relative">
                            {{ $msg->message }}
                            <span class="text-[9px] text-zinc-400 block mt-1 text-right">{{ $msg->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                @else
                    <div class="flex justify-end">
                        <div class="bg-zinc-950 text-white rounded-2xl rounded-tr-sm px-4 py-2 max-w-[80%] text-sm shadow-sm relative {{ $msg->sender_type === 'ai' ? 'bg-blue-900' : '' }}">
                            @if($msg->sender_type === 'ai')
                                <span class="text-[9px] text-blue-300 font-bold block mb-1 uppercase tracking-wider">AI Assistant</span>
                            @else
                                <span class="text-[9px] text-zinc-400 font-bold block mb-1 uppercase tracking-wider">Admin</span>
                            @endif
                            {!! nl2br(e($msg->message)) !!}
                            <span class="text-[9px] text-zinc-400 block mt-1 text-right">{{ $msg->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Reply Box -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 shrink-0">
            @if($conversation->ai_active)
                <div class="text-center text-sm font-bold text-zinc-500 py-2">
                    AI is currently handling this conversation. Take over to reply manually.
                </div>
            @else
                <form action="{{ route('admin.support.reply', $conversation) }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="message" required placeholder="Type your reply here..." class="flex-grow bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-zinc-500" autocomplete="off" autofocus />
                    <button type="submit" class="bg-zinc-950 text-white font-black px-6 py-3 rounded-lg text-sm uppercase tracking-wider hover:bg-zinc-800 transition">Send</button>
                </form>
            @endif
        </div>
    </div>
    
    <script>
        // Scroll to bottom
        const chatWindow = document.getElementById('chatWindow');
        chatWindow.scrollTop = chatWindow.scrollHeight;
    </script>
@endsection

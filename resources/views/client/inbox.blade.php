@extends('layouts.app')
@section('title', 'Messages — Harfa.ma')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-client')
  <div class="portal-content" style="padding:20px">

    <div class="chat-layout">

      {{-- Contacts list --}}
      <div class="chat-list">
        <div class="chat-list-header">
          <i class="bi bi-chat-dots me-2" style="color:#059669"></i>Messages
        </div>
        <div class="chat-list-scroll">
          @forelse($partners as $p)
            <a href="{{ route('client.inbox.chat', $p->id) }}"
               class="chat-contact {{ isset($partner) && $partner->id === $p->id ? 'active' : '' }}">
              <div class="contact-avatar">{{ strtoupper(substr($p->name, 0, 2)) }}</div>
              <div>
                <div class="contact-name">{{ $p->name }}</div>
                <div class="contact-preview">Cliquer pour discuter</div>
              </div>
            </a>
          @empty
            <div style="padding:24px;text-align:center;color:#94a3b8;font-size:13px">
              Aucune conversation pour l'instant
            </div>
          @endforelse
        </div>
      </div>

      {{-- Chat area --}}
      <div class="chat-main">
        @isset($partner)
          <div class="chat-header">
            <div class="header-avatar">{{ strtoupper(substr($partner->name, 0, 2)) }}</div>
            <div>
              <div class="header-name">{{ $partner->name }}</div>
              <div class="header-status">En ligne</div>
            </div>
          </div>

          <div class="chat-messages" id="chatMessages">
            @forelse($chats as $msg)
              <div class="message-bubble {{ $msg->sender_id === auth()->id() ? 'outgoing' : 'incoming' }}">
                {{ $msg->message }}
                <div class="msg-time">{{ $msg->created_at->format('H:i') }}</div>
              </div>
            @empty
              <div style="text-align:center;color:#94a3b8;font-size:14px;margin:auto">
                Démarrez la conversation avec {{ $partner->name }}
              </div>
            @endforelse
          </div>

          <div class="chat-input-area">
            <form method="POST" action="{{ route('client.inbox.send') }}" class="d-flex gap-2 flex-grow-1">
              @csrf
              <input type="hidden" name="receiver_id" value="{{ $partner->id }}">
              <input type="text" name="message" placeholder="Tapez votre message..." required autocomplete="off">
              <button type="submit"><i class="bi bi-send-fill"></i></button>
            </form>
          </div>
        @else
          <div style="display:flex;align-items:center;justify-content:center;flex:1;flex-direction:column;color:#94a3b8">
            <i class="bi bi-chat-dots" style="font-size:56px;opacity:.3;margin-bottom:16px"></i>
            <p style="font-size:15px">Sélectionnez une conversation</p>
          </div>
        @endisset
      </div>

    </div>
  </div>
</div>

@push('scripts')
<script>
  // Scroll to bottom of messages
  const msgs = document.getElementById('chatMessages');
  if(msgs) msgs.scrollTop = msgs.scrollHeight;
</script>
@endpush
@endsection

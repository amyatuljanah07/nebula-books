<div id="chat-widget-container" class="chat-widget-container">
    <!-- Chat Button -->
    <a href="{{ route('chat.index') }}" id="chat-toggle-btn" class="chat-toggle-btn" title="Chat with us">
        <i class="fas fa-comments"></i>
    </a>
</div>

<style>
    .chat-widget-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }

    .chat-toggle-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .chat-toggle-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
        color: white;
    }

    @media (max-width: 480px) {
        .chat-widget-container {
            bottom: 10px;
            right: 10px;
        }
        
        .chat-toggle-btn {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }
    }
</style>

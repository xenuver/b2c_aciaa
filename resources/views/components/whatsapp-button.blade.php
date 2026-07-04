@php
    $whatsappNumber = '6282156311243'; // Nomor admin
    $message = urlencode('Halo, saya ingin bertanya tentang produk di Aciaa Fashion Store');
    $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$message}";
@endphp

<div x-data="{ open: false }" class="whatsapp-widget position-fixed bottom-0 end-0 m-4">
    <!-- Chat Popup Box -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="whatsapp-chat-box"
         x-cloak>
        
        <!-- Header -->
        <div class="chat-header">
            <div class="chat-admin-info">
                <div class="admin-avatar">
                    <i class="fab fa-whatsapp"></i>
                    <span class="online-status"></span>
                </div>
                <div class="admin-text">
                    <span class="admin-name">Customer Service</span>
                    <span class="admin-status">Online (Tanggapan Cepat)</span>
                </div>
            </div>
            <button @click="open = false" class="close-chat-box">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Body -->
        <div class="chat-body">
            <div class="chat-message-bubble">
                <p>Halo! Selamat datang di <strong>Aciaa Fashion Store</strong> ✨</p>
                <p>Ada yang bisa kami bantu? Silakan tanyakan seputar produk, ukuran, atau pesanan Anda ya!</p>
                <span class="chat-time">{{ now()->format('H:i') }}</span>
            </div>
        </div>
        
        <!-- Footer / CTA Button -->
        <div class="chat-footer">
            <a href="{{ $whatsappUrl }}" target="_blank" class="chat-start-btn">
                <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
            </a>
        </div>
    </div>

    <!-- Floating Circular Button -->
    <button @click="open = !open" 
            class="whatsapp-trigger-btn"
            title="Hubungi Customer Service">
        <span class="pulse-ring"></span>
        <i class="fab fa-whatsapp"></i>
    </button>
</div>

<style>
.whatsapp-widget {
    z-index: 1080;
    font-family: var(--font-body, 'Montserrat', sans-serif);
}

/* Floating Circular Button */
.whatsapp-trigger-btn {
    width: 60px;
    height: 60px;
    background-color: #25D366;
    border-radius: 50%;
    border: none;
    color: white;
    font-size: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.35);
    position: relative;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.whatsapp-trigger-btn:hover {
    transform: scale(1.1) rotate(10deg);
    box-shadow: 0 12px 30px rgba(37, 211, 102, 0.5);
}

/* Pulse Ring Effect */
.pulse-ring {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: #25D366;
    opacity: 0.4;
    animation: pulse-ring-anim 2s infinite;
    z-index: -1;
}

@keyframes pulse-ring-anim {
    0% {
        transform: scale(0.95);
        opacity: 0.5;
    }
    50% {
        transform: scale(1.4);
        opacity: 0;
    }
    100% {
        transform: scale(0.95);
        opacity: 0;
    }
}

/* Chat Popup Box */
.whatsapp-chat-box {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 320px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    z-index: 1085;
}

/* Header */
.chat-header {
    background: #075E54;
    padding: 16px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-admin-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.admin-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    position: relative;
}

.online-status {
    width: 10px;
    height: 10px;
    background: #25D366;
    border: 2px solid #075E54;
    border-radius: 50%;
    position: absolute;
    bottom: 0;
    right: 0;
}

.admin-text {
    display: flex;
    flex-direction: column;
}

.admin-name {
    font-weight: 600;
    font-size: 0.95rem;
}

.admin-status {
    font-size: 0.75rem;
    opacity: 0.8;
}

.close-chat-box {
    background: none;
    border: none;
    color: white;
    opacity: 0.8;
    cursor: pointer;
    font-size: 16px;
    transition: opacity 0.2s;
}

.close-chat-box:hover {
    opacity: 1;
}

/* Body */
.chat-body {
    background: #e5ddd5;
    padding: 16px;
    min-height: 150px;
    max-height: 250px;
    overflow-y: auto;
}

.chat-message-bubble {
    background: white;
    padding: 12px;
    border-radius: 12px;
    border-top-left-radius: 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    font-size: 0.85rem;
    color: #333;
    line-height: 1.4;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.chat-message-bubble p {
    margin: 0;
}

.chat-time {
    font-size: 0.7rem;
    color: #999;
    align-self: flex-end;
}

/* Footer */
.chat-footer {
    padding: 12px 16px;
    background: #f0f0f0;
}

.chat-start-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: #25D366;
    color: white;
    text-decoration: none !important;
    padding: 10px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.2);
    transition: all 0.2s;
}

.chat-start-btn:hover {
    background: #1ebe5d;
    box-shadow: 0 6px 16px rgba(37, 211, 102, 0.3);
    transform: translateY(-2px);
    color: white;
}

@media (max-width: 480px) {
    .whatsapp-chat-box {
        width: 280px;
        bottom: 75px;
    }
}
</style>
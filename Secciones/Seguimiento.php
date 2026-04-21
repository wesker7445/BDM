<?php

?>

<section id="sec-seguimiento" class="content-section hidden">
    <header class="top-bar">
        <h2>Seguimiento de Unidad</h2>
        <span class="status-badge">Siniestro #12345 - En Reparación</span>
    </header>
    
    <div class="chat-container">
        <div class="chat-messages" id="chat-box">
            <div class="message outgoing">
                <div class="message-content">
                    <p>Hola, ¿cuál es el estado actual de mi Aveo?</p>
                    <span class="message-time">10:10 </span>
                </div>
            </div>

            <div class="message incoming">
                <div class="message-content">
                    <p>Buen día. La unidad ya se encuentra en hojalatería. Adjunto foto del avance.</p>
                    <img src="Multimedia/Imagen/aveo2.png" class="chat-img">
                    <span class="message-time">10:45</span>
                </div>
            </div>
        </div>

        <form class="chat-input-area" action="procesar_mensaje.php" method="POST" enctype="multipart/form-data">
            <label for="file-input" class="chat-icon-btn">
                <i class="fa-solid fa-paperclip"></i>
            </label>
            <input type="file" id="file-input" name="multimedia" class="hidden" accept="image/*,video/*">
            
            <input type="text" placeholder="Escribe un mensaje..." class="chat-input-field">
            
            <button type="submit" class="chat-send-btn">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>
</section>
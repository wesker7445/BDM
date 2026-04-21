<?php

?>

<section id="sec-dictamen" class="content-section hidden">
    <header class="top-bar">
        <h2>Resolución de Siniestro</h2>
    </header>

    <div class="form-siniestro-container">
        <form action="procesar_dictamen.php" method="POST">
            <div class="grupo-input">
                <label for="siniestroSel">Seleccionar Siniestro Pendiente</label>
                <select name="id_siniestro" id="siniestroSel">
                    <option value="12345">Siniestro #12345 - Aveo 2022 (Choque lateral)</option>
                    <option value="12346">Siniestro #12346 - Forte 2023 (Inundación)</option>
                </select>
            </div>

            <div class="grupo-input">
                <label for="montoPago">Monto Determinado ($)</label>
                <input type="text" id="montoPago" name="monto" placeholder="Ej. 45000.00">
            </div>

            <div class="grupo-input">
                <label for="resolucionS">Dictamen Final</label>
                <select name="resolucion" id="resolucionS">
                    <option value="reparacion">Autorizar Reparación en Taller</option>
                    <option value="pago_directo">Pago de Daños al Asegurado</option>
                    <option value="perdida_total">Aplicar Pérdida Total</option>
                </select>
            </div>

            <div class="grupo-input">
                <label for="obsS">Observaciones del Supervisor</label>
                <textarea id="obsS" name="observaciones" placeholder="Justificación del dictamen..."></textarea>
            </div>

            <input type="submit" class="boton-submit" value="Confirmar Resolución">
        </form>
    </div>
</section>
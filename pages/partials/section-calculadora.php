<?php
/**
 * Sección Calculadora
 * "Calcula una referencia inicial"
 * Backend via admin-post.php
 */

declare(strict_types=1);

$title = $lang === 'ca' ? 'Calcula una primera referència' : 'Calcula una referencia inicial';
$subtitle = $lang === 'ca'
    ? 'La calculadora no substitueix la visita tècnica. Serveix per entendre una forquilla inicial i preparar millor la conversa.'
    : 'La calculadora no sustituye la visita técnica. Sirve para entender una horquilla inicial y preparar mejor la conversación.';

$tipos = $lang === 'ca' ? [
    'reforma_integral' => 'Reforma integral',
    'obra_nueva' => 'Obra nova',
    'pladur' => 'Pladur i acabats',
    'obra_publica' => 'Obra pública',
    'obra_civil' => 'Obra civil',
] : [
    'reforma_integral' => 'Reforma integral',
    'obra_nueva' => 'Obra nueva',
    'pladur' => 'Pladur y acabados',
    'obra_publica' => 'Obra pública',
    'obra_civil' => 'Obra civil',
];

$ciudades = $lang === 'ca' ? [
    'barcelona' => 'Barcelona',
    'girona' => 'Girona',
    'tarragona' => 'Tarragona',
    'otros' => 'Altres',
] : [
    'barcelona' => 'Barcelona',
    'girona' => 'Girona',
    'tarragona' => 'Tarragona',
    'otros' => 'Otros',
];

$acabados = $lang === 'ca' ? [
    'basico' => 'Bàsic',
    'estandar' => 'Estàndard',
    'premium' => 'Premium',
] : [
    'basico' => 'Básico',
    'estandar' => 'Estándar',
    'premium' => 'Premium',
];

$label_tipo = $lang === 'ca' ? 'Tipus d\'obra' : 'Tipo de obra';
$label_m2 = $lang === 'ca' ? 'Metres quadrats' : 'Metros cuadrados';
$label_ciudad = $lang === 'ca' ? 'Ciutat' : 'Ciudad';
$label_acabado = $lang === 'ca' ? 'Nivell d\'acabat' : 'Nivel de acabado';
$label_email = $lang === 'ca' ? 'Correu electrònic' : 'Correo electrónico';
$cta = $lang === 'ca' ? 'Rebre pressupost detallat' : 'Recibir presupuesto detallado';
$result_label = $lang === 'ca' ? 'Forquilla estimada' : 'Horquilla estimada';
$disclaimer = $lang === 'ca'
    ? 'Inclou una variació del 18%. Llicències, estat inicial, estructura i instal·lacions poden canviar la xifra.'
    : 'Incluye una variación del 18%. Licencias, estado inicial, estructura e instalaciones pueden cambiar la cifra.';
$success_msg = $lang === 'ca'
    ? 'T\'enviarem el càlcul detallat per email en 24h.'
    : 'Te enviaremos el cálculo detallado por email en 24h.';
?>

<section data-reveal class="py-24 bg-slate-950 border-b border-slate-800" id="calculadora">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-[0.8fr_1.2fr] gap-12 items-start">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="industrial-line w-12"></div>
                    <span class="text-brand-400 text-xs font-semibold uppercase tracking-[0.3em]"><?php echo $lang === 'ca' ? 'Pressupost estimat' : 'Presupuesto estimado'; ?></span>
                </div>
                <h2 class="font-display font-bold text-4xl md:text-5xl text-white tracking-tight mb-5"><?php echo $title; ?></h2>
                <p class="text-slate-400 leading-relaxed"><?php echo $subtitle; ?></p>
            </div>

            <div class="bg-slate-900 border border-slate-800 rounded-sm p-6 md:p-8" data-budget-calculator>
                <form id="form-calculadora" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="santafe_calculadora">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="grid md:grid-cols-2 gap-5">
                        <label class="block">
                            <span class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo $label_tipo; ?></span>
                            <select name="tipo_obra" data-calc-service class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-slate-200 focus:border-brand-500 focus:outline-none">
                                <?php foreach ($tipos as $key => $val): ?>
                                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label class="block">
                            <span class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo $label_m2; ?></span>
                            <input type="number" name="metros" data-calc-m2 min="10" max="5000" value="80" class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-white focus:border-brand-500 focus:outline-none">
                        </label>
                        <label class="block">
                            <span class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo $label_ciudad; ?></span>
                            <select name="ciudad" data-calc-city class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-slate-200 focus:border-brand-500 focus:outline-none">
                                <?php foreach ($ciudades as $key => $val): ?>
                                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label class="block">
                            <span class="block text-slate-400 text-xs uppercase tracking-wider mb-2"><?php echo $label_acabado; ?></span>
                            <select name="acabado" data-calc-finish class="w-full bg-slate-950 border border-slate-700 rounded-sm px-4 py-3 text-slate-200 focus:border-brand-500 focus:outline-none">
                                <?php foreach ($acabados as $key => $val): ?>
                                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>

                    <div class="mt-6 bg-slate-950 border border-slate-800 rounded-sm p-6">
                        <p class="text-slate-500 text-xs uppercase tracking-wider mb-2"><?php echo $result_label; ?></p>
                        <p class="font-display font-bold text-3xl text-white" data-calc-result>—</p>
                        <p class="text-slate-500 text-sm mt-3"><?php echo $disclaimer; ?></p>
                        <p class="text-brand-400 text-sm mt-2"><?php echo $success_msg; ?></p>
                    </div>

                    <div class="flex flex-wrap gap-4 mt-6">
                        <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-6 py-3 rounded-sm transition-all tracking-wide text-sm uppercase">
                            <?php echo $cta; ?>
                        </button>
                        <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hola%20Paulo%2C%20quiero%20revisar%20un%20presupuesto%20estimado" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 border border-slate-600 hover:border-brand-500 text-slate-200 font-medium px-6 py-3 rounded-sm transition-all tracking-wide text-sm uppercase" data-track-event="whatsapp_click">
                            <?php echo $lang === 'ca' ? 'Enviar per WhatsApp' : 'Enviar por WhatsApp'; ?>
                        </a>
                    </div>

                    <div id="calculadora-resultado" class="mt-4"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
/**
 * Adım göstergesi (kayıt ve katkı akışları).
 *
 * Değişkenler (include'dan önce tanımlanır; sayfa değişkenleriyle çakışmasın diye önekli):
 *   $stepperSteps   : string[]  — zaten çevrilmiş adım etiketleri, ör. [t('stepper.venue'), t('stepper.products'), ...]
 *   $stepperCurrent : int       — 0 tabanlı aktif adım. count($stepperSteps) veya üstü → hepsi tamamlandı.
 *   $stepperDark    : bool      — (opsiyonel) lacivert zeminde ise true; kapsayıcıya .on-dark eklenir.
 *
 * Kullanım:
 *   <?php $stepperSteps = [...]; $stepperCurrent = 1; include ROOT . '/views/partials/stepper.php'; ?>
 */
$__ss  = $stepperSteps ?? [];
$__sc  = (int)($stepperCurrent ?? 0);
$__sn  = count($__ss);
?>
<nav aria-label="<?= e(t('stepper.aria')) ?>" class="<?= !empty($stepperDark) ? 'on-dark' : '' ?>">
    <ol class="stepper">
        <?php foreach ($__ss as $__si => $__sl): ?>
            <?php
            $__state = $__si < $__sc ? 'done' : ($__si === $__sc ? 'active' : 'pending');
            ?>
            <?php if ($__si > 0): ?>
                <li class="step-line<?= $__si <= $__sc ? ' step-line-done' : '' ?>" aria-hidden="true"></li>
            <?php endif; ?>
            <li class="step step-<?= $__state ?>"<?= $__state === 'active' ? ' aria-current="step"' : '' ?>>
                <span class="step-dot" aria-hidden="true">
                    <?php if ($__state === 'done'): ?>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 5 5 9-10"/></svg>
                    <?php else: ?>
                        <?= $__si + 1 ?>
                    <?php endif; ?>
                </span>
                <span class="step-label"><?= e($__sl) ?></span>
                <span class="sr-only"><?= $__state === 'done' ? ' — ' . e(t('stepper.done')) : ($__state === 'active' ? ' — ' . e(t('stepper.current')) : '') ?></span>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>


<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($categories_select as $value): ?>
            <li class="promo__item <?=$value['css_class']; ?>">
                <a class="promo__link" href="pages/all-lots.html"><?=$value['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">

        <?php foreach ($lots_select as $value): ?>

        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?=check_hakers($value['picture_link']); ?>" width="350" height="260" alt="">
            </div>
            <div class="lot__info">
                <span class="lot__category"><?=check_hakers($value['MAX(c.name)']); ?></span>
                <h3 class="lot__title"><a class="text-link" href="lot.php?value_id=<?=$value['id']; ?>"><?=check_hakers($value['name']); ?></a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <?php if (!empty($value['MAX(b.price_buy)'])): ?>
                           <span class="lot__cost"><?=check_hakers(space_price($value['MAX(b.price_buy)'])); ?></span>
                       <?php else: ?>
                           <span class="lot__cost"><?=check_hakers(space_price($value['start_price'])); ?></span>
                       <?php endif; ?>
                        <!--<span class="lot__cost"><?=check_hakers(space_price($value['start_price'])); ?></span>-->
                    </div>
                    <div class="lot__timer timer">
                        <?=show_date_close($value['date_close']); ?>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    </ul>
</section>

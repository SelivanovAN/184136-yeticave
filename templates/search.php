  <main>
    <nav class="nav">
      <ul class="nav__list container">
          <?php foreach ($categories_select as $value): ?>
              <li class="nav__item">
                  <a href="pages/all-lots.html"><?=$value['name']; ?></a>
              </li>
          <?php endforeach; ?>
      </ul>
    </nav>

    <div class="container">
      <section class="lots">

        <h2>Результаты поиска по запросу «<span><?=check_hakers($form_search); ?></span>»</h2>

        <ul class="lots__list">

            <?php if (count($result_lots_pagination_sql)): ?>

                <?php foreach ($result_lots_pagination_sql as $value): ?>
                    <li class="lots__item lot">
                      <div class="lot__image">
                        <img src="<?=check_hakers($value['picture_link']); ?>" width="350" height="260" alt="Сноуборд">
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

                          </div>
                          <div class="lot__timer timer"> <!-- timer--finishing -->
                              <?=show_date_close($value['date_close']); ?>
                          </div>
                        </div>
                      </div>
                    </li>

            <?php endforeach; ?>

            <?php else: ?>

                <p>Ничего не найдено по вашему запросу</p>

            <?php endif; ?>
        </ul>
      </section>

      <?php if ($tpl_data['pages_count'] > 1): ?>
          <!--<div class="pagination">-->
              <ul class="pagination-list">
                  <li class="pagination-item pagination-item-prev"><a href="/search.php?search=<?=check_hakers($form_search); ?>&page=1">Назад</a></li>

                  <?php foreach ($tpl_data['pages'] as $page): ?>
                      <li class="pagination-item <?php if ($page === $tpl_data['cur_page']): ?>pagination-item-active<?php endif; ?>">
                          <a href="/search.php?search=<?=check_hakers($form_search); ?>&page=<?=$page;?>"><?=$page;?></a>
                      </li>
                  <?php endforeach; ?>

                  <li class="pagination-item pagination-item-next"><a href="/search.php?search=<?=check_hakers($form_search); ?>&page=<?=$tpl_data['pages_count'];?>">Вперед</a></li>
              </ul>
          <!--</div>-->
      <?php endif; ?>
<!--
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
      </ul>
  -->
    </div>
  </main>

</div>

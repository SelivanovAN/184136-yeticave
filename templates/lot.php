  <main>
    <nav class="nav">
      <ul class="nav__list container">
          <?php foreach ($categories_select as $value): ?>
          <!--заполните этот список из массива категорий-->
          <li class="nav__item">
              <a href="pages/all-lots.html"><?=$value['name']; ?></a>
          </li>
          <?php endforeach; ?>
      </ul>
    </nav>
    <section class="lot-item container">
      <h2><?=check_hakers($lot_select['name']); ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="<?=check_hakers($lot_select['picture_link']); ?>" width="730" height="548" alt="Сноуборд">
          </div>
          <p class="lot-item__category">Категория: <span><?=check_hakers($lot_select['MAX(c.name)']); ?></span></p>
          <p class="lot-item__description"><?=check_hakers($lot_select['description']); ?></p>
        </div>

        <div class="lot-item__right">

        <?php if (isset($_SESSION['user']) && ($_SESSION['user']['id'] != $lot_select['id_user']) || strtotime($form_add_bet['date_close'] < time())): ?>

<!-- $_SESSION['id'] === $lot['userId'] || $user_has_bet
 || show_date_close($lot_select['date_close'] < date_create('now'))
isset($_SESSION['user']['id']) ===  $lot_select['id_user']

|| show_date_close($date_close['date_close']) < time("now")
strtotime($form_add_bet['date_close']) < time()
-->

          <div class="lot-item__state">
            <div class="lot-item__timer timer">
              <?=check_hakers(show_date_close($lot_select['date_close'])); ?>
            </div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                 <?php if (!empty($lot_select['MAX(b.price_buy)'])): ?>
                    <span class="lot-item__cost"><?=space_price(check_hakers($lot_select['MAX(b.price_buy)'])); ?></span>
                <?php else: ?>
                    <span class="lot-item__cost"><?=space_price(check_hakers($lot_select['start_price'])); ?></span>
                <?php endif; ?>
              </div>
              <div class="lot-item__min-cost">
                  <?php if (!empty($lot_select['MAX(b.price_buy)'])): ?>
                      Мин. ставка <span><?=space_price(check_hakers($lot_select['MAX(b.price_buy)'] + $lot_select['step_bet'])); ?></span>
                  <?php else: ?>
                      Мин. ставка <span><?=space_price(check_hakers($lot_select['start_price'] + $lot_select['step_bet'])); ?></span>
                  <?php endif; ?>
              </div>
            </div>

            <?php $form_classname = count($errors ?? []) ? "form--invalid" : ""; ?>

            <form class="lot-item__form <?=$form_classname;?>" method="post" enctype="multipart/form-data">

                <?php $classname = isset($errors['cost']) ? "form__item--invalid" : "";
                $error_value = isset($errors['cost']) ? $errors['cost'] : "";
                $value = isset($form_add_bet['cost']) ? $form_add_bet['cost'] : ""; ?>

              <p class="lot-item__form-item form__item <?=$classname;?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" class="<?=$classname;?>" type="text" name="add_bet[cost]" placeholder="<?=space_price(check_hakers($lot_select['MAX(b.price_buy)'] + $lot_select['step_bet'])); ?>">
                <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
              </p>
              <button type="submit" class="button">Сделать ставку</button>

            </form>
          </div>

          <div class="history">
            <h3>История ставок (<span><?=count($bets_select); ?></span>)</h3>
            <table class="history__list">

            <?php foreach ($bets_select as $value): ?>

              <tr class="history__item">
                <td class="history__name"><?=$value['name']; ?></td>
                <td class="history__price"><?=space_price($value['price_buy']); ?> р</td>
                <td class="history__time"><?=$value['date_place']; ?></td>
              </tr>

             <?php endforeach; ?>

            </table>
        </div>

        <?php else: ?>

            <div class="lot-item__state">
              <div class="lot-item__timer timer">
                <?=check_hakers(show_date_close($lot_select['date_close'])); ?>
              </div>
              <div class="lot-item__cost-state">
                <div class="lot-item__rate">
                  <span class="lot-item__amount">Текущая цена</span>
                   <?php if (!empty($lot_select['MAX(b.price_buy)'])): ?>
                      <span class="lot-item__cost"><?=space_price(check_hakers($lot_select['MAX(b.price_buy)'])); ?></span>
                  <?php else: ?>
                      <span class="lot-item__cost"><?=space_price(check_hakers($lot_select['start_price'])); ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </div>


        </div>
      </div>

      <?php endif; ?>

    </section>
  </main>

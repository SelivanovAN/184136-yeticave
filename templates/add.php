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
    <form class="form form--add-lot container form--invalid" action="/add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item form__item--invalid"> <!-- form__item--invalid -->
        <?php $classname = isset($errors['jpg[name]']) ? "form__item--invalid" : "";
        $value = isset($jpg[name]) ? $jpg[name] : ""; ?>

          <label for="lot-name">Наименование</label>
          <input id="lot-name" class="<?=$classname;?> type="text" name="jpg[name]" placeholder="Введите наименование лота" required>
          <span class="form__error <?=$classname;?>"><?=$value;?></span>
        </div>
        <div class="form__item">
          <label for="category">Категория</label>
          <select id="category" name="jpg[category]" required>
              <option value="">Выберите категорию</option>
              <?php foreach ($categories_select as $value): ?>
                  <option value="<?=$value['id']; ?>"><?=$value['name']; ?></option>
              <?php endforeach; ?>
          </select>
          <span class="form__error">Выберите категорию</span>
        </div>
      </div>
      <div class="form__item form__item--wide">
        <?php $classname = isset($errors['jpg[description]']) ? "form__item--invalid" : "";
        $value = isset($jpg['description']) ? $jpg['description'] : ""; ?>

        <label for="message">Описание</label>
        <textarea id="message" class="<?=$classname;?>" name="jpg[description]" placeholder="Напишите описание лота" required><?=$value;?></textarea>
        <!--<span class="form__error">Напишите описание лота</span>-->
        <span class="form__error <?=$classname;?>"><?=$value;?></span>
      </div>
      <div class="form__item form__item--file"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
          <button class="preview__remove" type="button">x</button>
          <div class="preview__img">
            <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
          </div>
        </div>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" name="file-upload" id="photo2" value="">
          <label for="photo2">
            <span>+ Добавить</span>
          </label>
        </div>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small">
            <?php $classname = isset($errors['jpg[start_price]']) ? "form__item--invalid" : "";
            $value = isset($jpg['start_price']) ? $jpg['start_price'] : ""; ?>

          <label for="lot-rate">Начальная цена</label>
          <input id="lot-rate" class="<?=$classname;?>" type="number" name="jpg[start_price]" placeholder="0" required>
          <span class="form__error <?=$classname;?>"><?=$value;?></span>
        </div>
        <div class="form__item form__item--small">
            <?php $classname = isset($errors['jpg[step_bet]']) ? "form__item--invalid" : "";
            $value = isset($jpg['step_bet']) ? $jpg['step_bet'] : ""; ?>

          <label for="lot-step">Шаг ставки</label>
          <input id="lot-step" class="<?=$classname;?>" type="number" name="jpg[step_bet]" placeholder="0" required>
          <span class="form__error <?=$classname;?>"><?=$value;?></span>
        </div>
        <div class="form__item">
          <label for="lot-date">Дата окончания торгов</label>
          <input class="form__input-date" id="lot-date" type="date" name="jpg[date_close]" required>
          <span class="form__error">Введите дату завершения торгов</span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
  </main>

</div>

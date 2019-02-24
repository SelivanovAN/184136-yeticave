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
    <?php $form_classname = count($errors) ? "form--invalid" : ""; ?>

    <form class="form form--add-lot container <?=$form_classname;?>" action="/add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">

          <?php $classname = isset($errors['name']) ? "form__item--invalid" : "";
          $error_value = isset($errors['name']) ? $errors['name'] : "";
          $value = isset($jpg['name']) ? $jpg['name'] : ""; ?>

        <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование</label>
          <input id="lot-name" class="<?=$classname;?>" type="text" name="jpg[name]" placeholder="Введите наименование лота" value="<?=$value;?>" >
          <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
        </div>

        <?php $classname = isset($errors['category']) ? "form__item--invalid" : "";
        $error_value = isset($errors['category']) ? $errors['category'] : "";
        $value = isset($jpg['category']) ? $jpg['category'] : ""; ?>

        <div class="form__item <?=$classname;?>">
          <label for="category">Категория</label>
          <select id="category" name="jpg[category]">
              <option value="">Выберите категорию</option>
              <?php foreach ($categories_select as $val): ?>
                  <option <?=$value==$val['id'] ? "selected": ""; ?> value="<?=$val['id']; ?>"><?=$val['name']; ?></option>
              <?php endforeach; ?>
          </select>
          <span class="form__error"><?=$error_value;?></span>
        </div>
      </div>

      <?php $classname = isset($errors['description']) ? "form__item--invalid" : "";
      $error_value = isset($errors['description']) ? $errors['description'] : "";
      $value = isset($jpg['description']) ? $jpg['description'] : ""; ?>

      <div class="form__item form__item--wide <?=$classname;?>">
        <label for="message">Описание</label>
        <textarea id="message" class="<?=$classname;?>" name="jpg[description]" placeholder="Напишите описание лота"><?=$value;?></textarea>
        <!--<span class="form__error">Напишите описание лота</span>-->
        <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
      </div>

      <?php $classname = isset($errors['file-upload']) ? "form__item--invalid" : "";
      $error_value = isset($errors['file-upload']) ? $errors['file-upload'] : ""; ?>

      <div class="form__item form__item--file <?=$classname;?>"> <!-- form__item--uploaded -->
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
        <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
      </div>

      <div class="form__container-three">

        <?php $classname = isset($errors['start_price']) ? "form__item--invalid" : "";
        $error_value = isset($errors['start_price']) ? $errors['start_price'] : "";
        $value = isset($jpg['start_price']) ? $jpg['start_price'] : ""; ?>

        <div class="form__item form__item--small <?=$classname;?>">
          <label for="lot-rate">Начальная цена</label>
          <input id="lot-rate" class="<?=$classname;?>" type="number" name="jpg[start_price]" placeholder="0" value="<?=$value;?>" >
          <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
        </div>

        <?php $classname = isset($errors['step_bet']) ? "form__item--invalid" : "";
        $error_value = isset($errors['step_bet']) ? $errors['step_bet'] : "";
        $value = isset($jpg['step_bet']) ? $jpg['step_bet'] : ""; ?>

        <div class="form__item form__item--small <?=$classname;?>">
          <label for="lot-step">Шаг ставки</label>
          <input id="lot-step" class="<?=$classname;?>" type="number" name="jpg[step_bet]" placeholder="0" value="<?=$value;?>" >
          <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
        </div>

        <?php $classname = isset($errors['date_close']) ? "form__item--invalid" : "";
        $error_value = isset($errors['date_close']) ? $errors['date_close'] : "";
        $value = isset($jpg['date_close']) ? $jpg['date_close'] : ""; ?>

        <div class="form__item <?=$classname;?>">
          <label for="lot-date">Дата окончания торгов</label>
          <input class="form__input-date <?=$classname;?>" id="lot-date" type="date" name="jpg[date_close]" value="<?=$value;?>">
          <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
  </main>

</div>

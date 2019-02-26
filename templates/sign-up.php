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

    <?php $form_classname = count($errors) ? "form--invalid" : ""; ?>

    <form class="form container <?=$form_classname;?>" action="/sign-up.php" method="post" enctype="multipart/form-data">
      <h2>Регистрация нового аккаунта</h2>

      <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";
      $error_value = isset($errors['email']) ? $errors['email'] : "";
      $value = isset($reg['email']) ? $reg['email'] : ""; ?>

      <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" class="<?=$classname;?>" type="text" name="signup[email]" placeholder="Введите e-mail" value="<?=$value;?>">
        <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
      </div>

      <?php $classname = isset($errors['password']) ? "form__item--invalid" : "";
      $error_value = isset($errors['password']) ? $errors['password'] : "";
      $value = isset($reg['password']) ? $reg['password'] : ""; ?>

      <div class="form__item <?=$classname;?>">
        <label for="password">Пароль*</label>
        <input id="password" class="<?=$classname;?>" type="text" name="signup[password]" placeholder="Введите пароль" value="<?=$value;?>">
        <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
      </div>

      <?php $classname = isset($errors['name']) ? "form__item--invalid" : "";
      $error_value = isset($errors['name']) ? $errors['name'] : "";
      $value = isset($reg['name']) ? $reg['name'] : ""; ?>

      <div class="form__item <?=$classname;?>">
        <label for="name">Имя*</label>
        <input id="name" class="<?=$classname;?>" type="text" name="signup[name]" placeholder="Введите имя" value="<?=$value;?>">
        <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
      </div>

      <?php $classname = isset($errors['message']) ? "form__item--invalid" : "";
      $error_value = isset($errors['message']) ? $errors['message'] : "";
      $value = isset($reg['message']) ? $reg['message'] : ""; ?>

      <div class="form__item <?=$classname;?>">
        <label for="message">Контактные данные*</label>
        <textarea id="message" class="<?=$classname;?>" name="signup[message]" placeholder="Напишите как с вами связаться"><?=$value;?></textarea>
        <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
      </div>

      <?php $classname = isset($errors['file-upload']) ? "form__item--invalid" : "";
      $error_value = isset($errors['file-upload']) ? $errors['file-upload'] : ""; ?>

      <div class="form__item form__item--file form__item--last <?=$classname;?>">
        <label>Аватар</label>
        <div class="preview">
          <button class="preview__remove" type="button">x</button>
          <div class="preview__img">
            <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
          </div>
        </div>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" name="file-upload" id="photo2" value="">
          <label for="photo2">
            <span>+ Добавить</span>
          </label>
        </div>
      </div>
      <span class="form__error form__error--bottom <?=$classname;?>"><?=$error_value;?></span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="/login.php">Уже есть аккаунт</a>
    </form>
</main>

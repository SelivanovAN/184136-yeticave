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

    <?php $form_classname = count($errors ?? []) ? "form--invalid" : ""; ?>

    <form class="form container <?=$form_classname;?>" action="/login.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Вход</h2>

      <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";
      $error_value = isset($errors['email']) ? $errors['email'] : "";
      $value = isset($form_enter['email']) ? $form_enter['email'] : ""; ?>

      <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" class="<?=$classname;?>" type="text" name="enter[email]" placeholder="Введите e-mail" value="<?=$value;?>">
        <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
      </div>

      <?php $classname = isset($errors['password']) ? "form__item--invalid" : "";
      $error_value = isset($errors['password']) ? $errors['password'] : "";
      $value = isset($form_enter['password']) ? $form_enter['password'] : ""; ?>

      <div class="form__item form__item--last  <?=$classname;?>">
        <label for="password">Пароль*</label>
        <input id="password" class="<?=$classname;?>" type="text" name="enter[password]" placeholder="Введите пароль" value="<?=$value;?>">
        <span class="form__error <?=$classname;?>"><?=$error_value;?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>

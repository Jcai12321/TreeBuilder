<ul data-storagekey="demoTree">
  
  <? foreach ($items as $item) : ?>

  <li data-branch="branch_<?= $item['cca2']; ?>">

    <? if (!empty($item['children'])) : ?>
    
    <button rel="toggle">
      <span class="plus">+</span>
      <span class="minus">-</span>
    </button>
    
    <? endif; ?>

    <a href="#"><?= $item['name']; ?></a>
    
    <small>[<?= implode('/', $item['path']); ?>]</small>

    <?= $this->render('tree.php', $item['children']); ?>

  </li>

  <? endforeach; ?>

</ul>
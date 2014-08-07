<ul data-storagekey="tree">
  
  <? foreach ($items as $item) : ?>

  <li data-branch="branch_<?= $item['id']; ?>">

    <button rel="toggle">
      <span class="plus">+</span>
      <span class="minus">-</span>
    </button>

    <a href="#"><?= $item['name']; ?></a>

    <?= renderBranch($item['sub']); ?>

  </li>

  <? endforeach; ?>

</ul>
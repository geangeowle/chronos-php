<div class="pagination-box-layout">
    <ul class="pagination pagination-sm no-margin pull-left">
    <?php if($currentPage > 1) { ?>
        <li>
            <a href="<?php echo $firstPageLink; ?>">&laquo;</a>
        </li>
    <?php } ?>
    <?php foreach ($numbers as $number) { ?>
        <?php if (!$number['active']) { ?>
        <li>
            <a href="<?php echo $number['link']; ?>"><?php echo $number['text']; ?></a>
        </li>
        <?php } else { ?>
        <li class="active">
            <a href="#"><?php echo $number['text']; ?></a>
        </li>
        <?php } ?>
    <?php } ?>
    <?php if($currentPage < $totalPages) { ?>
        <li>
            <a href="<?php echo $lastPageLink; ?>">&raquo;</a>
        </li>
    <?php } ?>
    </ul>
    <p class="pull-left remaining">mostrando <?php echo $currentNumRecords; ?> de <?php echo $totalRecords; ?> registros</p>
</div>

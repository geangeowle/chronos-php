<div class="pagination-box-layout clearfix">
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
    <?php if (count($numbers) > 0) { ?>
        <p class="pull-left remaining"><?php echo $totalRecords; ?> cadastro(s), <?php echo $totalPages; ?> pagina(s)</p>
    <?php } ?>
</div>

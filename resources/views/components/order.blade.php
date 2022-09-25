<td>
    <?php
    echo Form::text('order[' . $v->id . ']', $v->order, ['class' => 'form-control sort-order', 'data-module' => $module, 'data-id' => $v->id, 'style' => 'width:50px;text-align:right;']);
    ?>
</td>
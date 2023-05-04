<button class="open-pieces-dialog"><?= $labels->add_new_item  ?></button>
<div id="concert-pieces-dialog" class="hidden" style="max-width:800px">
    <label for="<?= $this->name ?>-select" ><b>Piece: </b></label>
    <select id="<?= $this->name ?>-select" name="<?= $this->name ?>-select" >
    </select><br />
    <button id="<?= $this->name ?>-select-button" name="<?= $this->name ?>-select-button" >Add ...</button>
</div>
<input type="hidden" name="<?= $this->name ?>" id="<?= $this->name ?>" value="<?= htmlspecialchars($this->getRawValue($post)) ?>" />
<?php 
$this->customPostTypeTable->display() 
?>
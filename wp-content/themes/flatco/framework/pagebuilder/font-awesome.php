<div class="fontawesome-ajax-data">
    <div class="general-field-container">
        <div class="field-item type-select">
            <div class="field-title">Icon Type</div>
            <div class="field-data">
                <select data-name="icon_type" data-type="select" class="field"><option value="fa" hide="none">Font Awesome</option><option value="sl" hide="none">Simple Line</option></select><span class="select-text"></span>
            </div>
            <div class="field-desc"></div>
        </div>
        <div class="field-item type-color">
            <div class="field-title">Font Color</div>
            <div class="field-data">
                <input data-name="fa_color" data-type="color" class="field" value="" placeholder="" type="text" />
                <div class="color-info"></div>
            </div>
            <div class="field-desc">Color.</div>
        </div>
        <div class="field-item type-color">
            <div class="field-title">Border Color</div>
            <div class="field-data">
                <input data-name="fa_border_color" data-type="color" class="field" value="" placeholder="" type="text" />
                <div class="color-info"></div>
            </div>
            <div class="field-desc">Border Color.</div>
        </div>
        <div class="field-item type-color">
            <div class="field-title">Background Color</div>
            <div class="field-data">
                <input data-name="fa_bg_color" data-type="color" class="field" value="" placeholder="" type="text" />
                <div class="color-info"></div>
            </div>
            <div class="field-desc">Background Color.</div>
        </div>
        <div class="field-item type-select">
            <div class="field-title">Type</div>
            <div class="field-data">
                <select data-name="fa_type" data-type="select" class="field"><option value="circle" hide="">Circle</option><option value="square" hide="">Square</option></select>
                <span class="select-text" style="width: 162px;"></span>
            </div>
            <div class="field-desc">type.</div>
        </div>
        <div class="field-item type-text">
            <div class="field-title">Font Size</div>
            <div class="field-data">
                <input data-name="fa_size" data-type="text" class="field" value="" placeholder="" data-selector="" data-save-to="" type="number" min="0"/>
            </div>
            <div class="field-desc">Size.</div>
        </div>
        <div class="field-item type-text">
            <div class="field-title">Font Padding</div>
            <div class="field-data">
                <input data-name="fa_padding" data-type="text" class="field" value="" placeholder="" data-selector="" data-save-to="" type="number" min="0"/>
            </div>
            <div class="field-desc">Padding.</div>
        </div>
        <div class="field-item type-text">
            <div class="field-title">Border width Size</div>
            <div class="field-data">
                <input data-name="fa_rounded" data-type="text" class="field" value="" placeholder="" data-selector="" data-save-to="" type="number" min="0"/>
            </div>
            <div class="field-desc">Border width Size.</div>
        </div>
        <div class="field-item hidden type-hidden">
            <div class="field-title">Icon</div>
            <div class="field-data">
                <input data-name="fa_icon" data-type="hidden" class="field" value="" placeholder="" data-selector="" data-save-to="" type="hidden" />
            </div>
            <div class="field-desc">Icon.</div>
        </div>
    </div>
    <div class="fontawesome-field-container">
        <div class="container">
            <div class="fa-viewer"></div>
            <?php include(THEME_PATH . "/framework/pagebuilder/font-awesome-list.php"); ?>
        </div>
    </div>
</div>
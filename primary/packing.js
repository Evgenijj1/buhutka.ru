jQuery(document).ready(function(){

    jQuery(".country_code").focusout(function(){

        if(this.value.length==3){
            var _this=this;
        jQuery.ajax({
            type:'POST',
            url: 'ajax/find_code.php',
            data: 'code='+this.value,
            dataType: 'json',
            success(data){
                var tr = jQuery(_this).parents("tr").get(0);
                var country = jQuery("input.country", tr);
                country.val(data.shortName);
            }
        });
    }
    });

    jQuery(".ks").focusout(function(){
        var err = new Error();
        var str = this.name.replace("ks_bank", "");
        if(/[0-9]{9}/.test(this.value))
            if(!validateKs(this.value,jQuery('[name=BIC'+str+']').get(0).value,err)){
                jQuery(jQuery('.'+this.name+'_error').get(0)).text(err.message);
            }else{
                jQuery(jQuery('.'+this.name+'_error').get(0)).text('');
            }
    });

    jQuery(".ogrn").focusout(function(){
        var err = new Error();
        if(validateOgrnip(this.value,err)){
            jQuery(jQuery('.'+this.name+'_error').get(0)).text('');

        }else if(validateOgrn(this.value,err)){
            jQuery(jQuery('.'+this.name+'_error').get(0)).text('');
        }else{
            jQuery(jQuery('.'+this.name+'_error').get(0)).text(err.message);
        }
    });

    jQuery(".kpp").focusout(function(){
        var err = new Error();
        if(!validateKpp(this.value,err)){
            jQuery(jQuery('.'+this.name+'_error').get(0)).text(err.message);
        }else{
            jQuery(jQuery('.'+this.name+'_error').get(0)).text('');
        }
    });

    jQuery(".rs").focusout(function(){
        var err = new Error();
        var str = this.name.replace("rs", "");
        if(/[0-9]{9}/.test(this.value))
            if(!validateRs(this.value,jQuery('[name=BIC'+str+']').get(0).value,err)){
                jQuery(jQuery('.'+this.name+'_error').get(0)).text(err.message);
            }else{
                jQuery(jQuery('.'+this.name+'_error').get(0)).text('');
            }
    });

    jQuery(".visible").focusout(function(){
        var err = new Error();
        if(validateInn(this.value,err)) {
            jQuery(jQuery('.'+this.name+'_error').get(0)).text('');
            var l=true;
            var _this=this;
            jQuery.ajax({
                type:'POST',
                url: 'ajax/find_INN.php',
                data: 'INN='+this.value,
                dataType: 'json',
                success(data){
                if(data){
                    l=false;
                    var str=_this.name.replace("INN","");
                    for (k in data) {
                        if (jQuery(jQuery("." + _this.name)[0]).children().is('[name=' + k + str + ']'))jQuery(jQuery("." + _this.name)[0]).children('[name=' + k + str + ']').get(0).value = data[k];
                    };
                }}
        });
        if(false) {
            var obj = jQuery.get('ajax/convert.php?inn='+this.value);
            obj.success((data)=>{
                var str=this.name.replace("INN","");
            var dat=JSON.parse(data)["list"][0];
            for (k in dat) {
                if(k!='inn' && k!='id') if(jQuery(jQuery("."+this.name)[0]).children().is('[name='+k+str+']'))jQuery(jQuery("."+this.name)[0]).children('[name='+k+str+']').get(0).value=dat[k];

            }
        });
    }
    jQuery(jQuery("."+this.name)[0]).show('slow');
}else if(this.value.length!=0){
    jQuery(jQuery('.'+this.name+'_error').get(0)).text(err.message);
}
});
jQuery(".visible_b").focusout(function(){
    var err = new Error();
    if (validateBik(this.value,err)) {
        jQuery(jQuery('.'+this.name+'_error').get(0)).text('');
        var l=true;
        var _this=this;
        jQuery.ajax({
            type:'POST',
            url: 'ajax/find_BIC.php',
            data: 'BIC='+this.value,
            dataType: 'json',
            success(data){
            if(data){
                l=false;
                var str=_this.name.replace("BIC","");
                for (k in data) {
                    if (jQuery(jQuery("." + _this.name)[0]).children().is('[name=' + k+'_bank' + str + ']'))jQuery(jQuery("." + _this.name)[0]).children('[name=' + k+'_bank' + str + ']').get(0).value = data[k];
                };
            }}
    });
    if(l) {
        var obj = jQuery.get('https://htmlweb.ru/service/api.php?bic=' + this.value + '&json&api_key=cd6ea810ab6658cc3c129e7847687a2a');
        obj.success((data) => {
            var str = this.name.replace("BIC", "");
        for (k in data) {
            if ((jQuery(jQuery("." + this.name)[0]).children().is('[name=' + k+'_bank' + str + ']'))) jQuery(jQuery("." + this.name)[0]).children('[name=' + k + '_bank' + str + ']').get(0).value = data[k];
        }
    });
}
jQuery(jQuery("."+this.name)[0]).show('slow');
}else if(this.value.length!=0){
    jQuery(jQuery('.'+this.name+'_error').get(0)).text(err.message);
}
});
jQuery(".visible_r").click(function(){
    //jQuery(jQuery(jQuery("."+this.name)[0]).children('input')).attr('required','required');
    jQuery('.require_'+this.name).attr('required','');
    jQuery(jQuery("."+this.name)[0]).show('slow');
});
jQuery(".hidden_r").click(function(){
    //jQuery(jQuery("."+this.name)[0]).children('input').removeAttr('required');
    jQuery('.require_'+this.name).removeAttr('required');
    jQuery(jQuery("."+this.name)[0]).hide('slow');
});
jQuery("input.kol_item, input.price_item").on('focusout',on_qnt_change);

jQuery("#Addstring").bind("click",add_row);

jQuery(".tel").mask("+7(999) 999-99-99");
jQuery(".date").mask("99.99.9999");
//jQuery(".rs").mask("99999999999999999999");
//jQuery(".ks").mask("99999999999999999999");
//jQuery(".okpo").mask("99999999");
//jQuery(".ogrn").mask("9999999999999");

set_events();

count_totals();
});

function save_comp() {
    var msg   = jQuery('#form_packing').serialize();
    jQuery.ajax({
        type: 'POST',
        url: 'ajax/res.php',
        data: msg
    });
}

function save_list() {
    var msg   = jQuery('#form_packing').serialize();
    jQuery.ajax({
        type: 'POST',
        url: 'ajax/save_list.php',
        data: msg
    }).done(function(data){
        //console.log(data);
        var res = JSON.parse(data);
        alert(res.msg);
    });
}


function set_events() {
    jQuery("img.delete").click(delete_row);
    jQuery("input.qnt, input.prc").blur(on_qnt_change);
    jQuery("select.nds").change(on_qnt_change);
    jQuery("input.sum").blur(on_sum_change);
}

function check_values(tr) {
    var sum_input = jQuery("input.sum", tr);
    var qnt_input = jQuery("input.qnt", tr);
    var prc_input = jQuery("input.prc", tr);

    var qnt = parseFloat(qnt_input.val()).toFixed(3);
    var prc = parseFloat(prc_input.val()).toFixed(2);
    var sum = parseFloat(sum_input.val()).toFixed(2);

    if (isNaN(qnt)) qnt_input.val("")
    else qnt_input.val(qnt);

    if (isNaN(prc)) prc_input.val("")
    else prc_input.val(prc);

    if (isNaN(sum)) sum_input.val("")
    else sum_input.val(sum);

}

function on_qnt_change() {
    var tr = jQuery(this).parents("tr").get(0);

    var sum_input = jQuery("input.sum", tr);
    var qnt_input = jQuery("input.qnt", tr);
    var prc_input = jQuery("input.prc", tr);

    var qnt = parseFloat(qnt_input.val());
    var prc = parseFloat(prc_input.val());

    if ((!isNaN(qnt))||(!isNaN(prc))) sum_input.val(qnt*prc);

    check_values(tr);
    count_totals();
}

function count_totals() {
    var total_nds = 0;
    var total_sum = 0;
    jQuery("tr.roww", jQuery("#tble")).each(
        function()
        {
            var row_sum = parseFloat(jQuery("input.sum", this).val());
            var row_nds = parseFloat(jQuery("select.nds", this).val());
            if (!isNaN(row_sum)) total_sum = total_sum + row_sum;
            if (!isNaN(row_nds) && !isNaN(row_sum)) total_nds = total_nds + row_sum-(row_sum/(1+row_nds/100)).toFixed(2);
        }
    );
    jQuery("#total_value").val((total_sum-total_nds).toFixed(2));
    jQuery("#total_nds").val(total_nds.toFixed(2));
    jQuery("#total_sum").val(total_sum.toFixed(2));
}

function on_sum_change() {
    var tr = jQuery(this).parents("tr").get(0);

    var prc_input = jQuery("input.prc", tr);
    var qnt = parseFloat(jQuery("input.qnt", tr).val());
    var sum = parseFloat(jQuery("input.sum", tr).val());

    if (qnt==0) prc_input.val(0)
    else prc_input.val((sum/qnt));

    check_values(tr);
    count_totals();
}

function delete_row() {
    jQuery(this).parents("tr").remove();
    count_totals();
}
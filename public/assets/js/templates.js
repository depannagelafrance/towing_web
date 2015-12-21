this["Handlebars"] = this["Handlebars"] || {};
this["Handlebars"]["Templates"] = this["Handlebars"]["Templates"] || {};

this["Handlebars"]["Templates"]["activity/activitylist"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
  var stack1, helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression, buffer = "<div class=\"work-container__field\" data-id=\""
    + escapeExpression(((helper = (helper = helpers.activity_id || (depth0 != null ? depth0.activity_id : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"activity_id","hash":{},"data":data}) : helper)))
    + "\" data-incl=\""
    + escapeExpression(((helper = (helper = helpers.fee_incl_vat || (depth0 != null ? depth0.fee_incl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"fee_incl_vat","hash":{},"data":data}) : helper)))
    + "\" data-excl=\""
    + escapeExpression(((helper = (helper = helpers.fee_excl_vat || (depth0 != null ? depth0.fee_excl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"fee_excl_vat","hash":{},"data":data}) : helper)))
    + "\">\n<div class=\"form-item-vertical work-container__task\">\n<input type=\"text\" name=\"name[]\" value=\""
    + escapeExpression(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"name","hash":{},"data":data}) : helper)))
    + " ("
    + escapeExpression(((helper = (helper = helpers.timeframe_name || (depth0 != null ? depth0.timeframe_name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"timeframe_name","hash":{},"data":data}) : helper)))
    + ")\" readonly=\"readonly\" style=\"background: #F0F0F0\">\n<input type=\"hidden\" name=\"activity_id[]\" value=\""
    + escapeExpression(((helper = (helper = helpers.activity_id || (depth0 != null ? depth0.activity_id : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"activity_id","hash":{},"data":data}) : helper)))
    + "\">\n</div>\n<div class=\"form-item-vertical work-container__number\">\n";
  stack1 = ((helpers.equal || (depth0 && depth0.equal) || helperMissing).call(depth0, (depth0 != null ? depth0.is_modifiable : depth0), 1, {"name":"equal","hash":{},"fn":this.program(2, data),"inverse":this.noop,"data":data}));
  if (stack1 != null) { buffer += stack1; }
  stack1 = ((helpers.equal || (depth0 && depth0.equal) || helperMissing).call(depth0, (depth0 != null ? depth0.is_modifiable : depth0), 0, {"name":"equal","hash":{},"fn":this.program(4, data),"inverse":this.noop,"data":data}));
  if (stack1 != null) { buffer += stack1; }
  return buffer + "</div>\n<div class=\"form-item-vertical work-container__excl\">\n<input type=\"text\" name=\"cal_fee_excl_vat[]\" value=\""
    + escapeExpression(((helpers.formatNumber || (depth0 && depth0.formatNumber) || helperMissing).call(depth0, (depth0 != null ? depth0.fee_excl_vat : depth0), {"name":"formatNumber","hash":{},"data":data})))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0\">\n</div>\n<div class=\"form-item-vertical work-container__incl\">\n<input type=\"text\" name=\"fee_incl_vat[]\" value=\""
    + escapeExpression(((helpers.formatNumber || (depth0 && depth0.formatNumber) || helperMissing).call(depth0, (depth0 != null ? depth0.fee_incl_vat : depth0), {"name":"formatNumber","hash":{},"data":data})))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0\">\n</div>\n<div class=\"form-item-vertical work-container__tot__excl\">\n<input type=\"text\" name=\"cal_fee_incl_vat[]\" value=\""
    + escapeExpression(((helpers.math || (depth0 && depth0.math) || helperMissing).call(depth0, (depth0 != null ? depth0.amount : depth0), "*", (depth0 != null ? depth0.fee_excl_vat : depth0), {"name":"math","hash":{},"data":data})))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0\">\n</div>\n<div class=\"form-item-vertical work-container__tot__incl\">\n<input type=\"text\" name=\"cal_fee_incl_vat[]\" value=\""
    + escapeExpression(((helpers.math || (depth0 && depth0.math) || helperMissing).call(depth0, (depth0 != null ? depth0.amount : depth0), "*", (depth0 != null ? depth0.fee_incl_vat : depth0), {"name":"math","hash":{},"data":data})))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0\">\n</div>\n<div class=\"form-item-vertical work-container__remove\" data-id=\""
    + escapeExpression(((helper = (helper = helpers.activity_id || (depth0 != null ? depth0.activity_id : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"activity_id","hash":{},"data":data}) : helper)))
    + "\">\n<div class=\"work-container__remove__btn\">\n<div class=\"btn--icon--small\">\n<a class=\"icon--remove--small\" href=\"#\">Remove</a>\n</div>\n</div>\n</div>\n</div>\n";
},"2":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "    <input type=\"text\" name=\"amount[]\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount || (depth0 != null ? depth0.amount : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount","hash":{},"data":data}) : helper)))
    + "\">\n";
},"4":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "    <input type=\"text\" name=\"amount[]\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount || (depth0 != null ? depth0.amount : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount","hash":{},"data":data}) : helper)))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0\">\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers.each.call(depth0, (depth0 != null ? depth0.activities : depth0), {"name":"each","hash":{},"fn":this.program(1, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"useData":true});

this["Handlebars"]["Templates"]["activity/additionalcosts"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "<div class=\"additional-costs-container__field\">\n  <div class=\"form-item-vertical additional-costs-container__task\">\n    <input type=\"text\" name=\"cost_name[]\" value=\""
    + escapeExpression(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"name","hash":{},"data":data}) : helper)))
    + "\">\n    <input type=\"hidden\" name=\"cost_id[]\" value=\""
    + escapeExpression(((helper = (helper = helpers.id || (depth0 != null ? depth0.id : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"id","hash":{},"data":data}) : helper)))
    + "\">\n  </div>\n  <div class=\"form-item-vertical additional-costs-container__excl\">\n    <input type=\"text\" name=\"cost_fee_excl_vat[]\" value=\""
    + escapeExpression(((helpers.formatNumber || (depth0 && depth0.formatNumber) || helperMissing).call(depth0, (depth0 != null ? depth0.fee_excl_vat : depth0), {"name":"formatNumber","hash":{},"data":data})))
    + "\">\n  </div>\n  <div class=\"form-item-vertical additional-costs-container__incl\">\n    <input type=\"text\" name=\"cost_fee_incl_vat[]\" value=\""
    + escapeExpression(((helpers.formatNumber || (depth0 && depth0.formatNumber) || helperMissing).call(depth0, (depth0 != null ? depth0.fee_incl_vat : depth0), {"name":"formatNumber","hash":{},"data":data})))
    + "\">\n  </div>\n  <div class=\"form-item-vertical additional-costs-container__remove\" data-id=\""
    + escapeExpression(((helper = (helper = helpers.id || (depth0 != null ? depth0.id : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"id","hash":{},"data":data}) : helper)))
    + "\">\n    <div class=\"additional-costs-container__remove__btn\">\n      <div class=\"btn--icon--small\">\n        <a class=\"icon--remove--small\" href=\"#\">Remove</a>\n      </div>\n    </div>\n  </div>\n</div>\n";
},"3":function(depth0,helpers,partials,data) {
  return "<div class=\"additional-costs-container__field\">\n  <div class=\"form-item-vertical additional-costs-container__task\">\n    <input type=\"text\" name=\"cost_name[]\" value=\"\">\n    <input type=\"hidden\" name=\"cost_id[]\" value=\"\">\n  </div>\n  <div class=\"form-item-vertical additional-costs-container__excl\">\n    <input type=\"text\" name=\"cost_fee_excl_vat[]\" value=\"\">\n  </div>\n  <div class=\"form-item-vertical additional-costs-container__incl\">\n    <input type=\"text\" name=\"cost_fee_incl_vat[]\" value=\"\">\n  </div>\n</div>\n";
  },"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers.each.call(depth0, (depth0 != null ? depth0.costs : depth0), {"name":"each","hash":{},"fn":this.program(1, data),"inverse":this.program(3, data),"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"useData":true});

this["Handlebars"]["Templates"]["activity/checkboxes"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "<div class=\"form-item-checkbox\">\n<input type=\"checkbox\" name=\"activity\" value=\""
    + escapeExpression(((helper = (helper = helpers.id || (depth0 != null ? depth0.id : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"id","hash":{},"data":data}) : helper)))
    + "|"
    + escapeExpression(((helper = (helper = helpers.default_value || (depth0 != null ? depth0.default_value : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"default_value","hash":{},"data":data}) : helper)))
    + "\" data-default=\""
    + escapeExpression(((helper = (helper = helpers.default_value || (depth0 != null ? depth0.default_value : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"default_value","hash":{},"data":data}) : helper)))
    + "\" data-id=\""
    + escapeExpression(((helper = (helper = helpers.id || (depth0 != null ? depth0.id : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"id","hash":{},"data":data}) : helper)))
    + "\"  data-label=\""
    + escapeExpression(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"name","hash":{},"data":data}) : helper)))
    + "\" data-code=\""
    + escapeExpression(((helper = (helper = helpers.code || (depth0 != null ? depth0.code : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"code","hash":{},"data":data}) : helper)))
    + "\" data-incl=\""
    + escapeExpression(((helper = (helper = helpers.fee_incl_vat || (depth0 != null ? depth0.fee_incl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"fee_incl_vat","hash":{},"data":data}) : helper)))
    + "\" data-excl=\""
    + escapeExpression(((helper = (helper = helpers.fee_excl_vat || (depth0 != null ? depth0.fee_excl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"fee_excl_vat","hash":{},"data":data}) : helper)))
    + "\" data-number-locked=\""
    + escapeExpression(((helper = (helper = helpers.is_modifiable || (depth0 != null ? depth0.is_modifiable : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"is_modifiable","hash":{},"data":data}) : helper)))
    + "\">\n<label>"
    + escapeExpression(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"name","hash":{},"data":data}) : helper)))
    + "</label>\n</div>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers.each.call(depth0, (depth0 != null ? depth0.activities : depth0), {"name":"each","hash":{},"fn":this.program(1, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer + "\n\n";
},"useData":true});

this["Handlebars"]["Templates"]["activity/paymentdetails"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
  var stack1, helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression, buffer = "\n<div class=\"form-item-vertical\">\n    <div style=\"float: left; width:10%; padding-right: 3px;\">\n      "
    + escapeExpression(((helper = (helper = helpers.category_display_name || (depth0 != null ? depth0.category_display_name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"category_display_name","hash":{},"data":data}) : helper)))
    + "\n      <input type=\"hidden\" name=\"payment_detail_id[]\" value=\""
    + escapeExpression(((helper = (helper = helpers.id || (depth0 != null ? depth0.id : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"id","hash":{},"data":data}) : helper)))
    + "\">\n      <input type=\"hidden\" name=\"towing_voucher_payment_id[]\" value=\""
    + escapeExpression(((helper = (helper = helpers.towing_voucher_payment_id || (depth0 != null ? depth0.towing_voucher_payment_id : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"towing_voucher_payment_id","hash":{},"data":data}) : helper)))
    + "\">\n    </div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\">\n      <select name=\"payment_detail_foreign_vat[]\" class=\"paymentdetail-vat-field\">\n        <option value=\"1\" ";
  stack1 = ((helpers.equal || (depth0 && depth0.equal) || helperMissing).call(depth0, (depth0 != null ? depth0.foreign_vat : depth0), 1, {"name":"equal","hash":{},"fn":this.program(2, data),"inverse":this.noop,"data":data}));
  if (stack1 != null) { buffer += stack1; }
  buffer += ">Ja</option>\n        <option value=\"0\" ";
  stack1 = ((helpers.equal || (depth0 && depth0.equal) || helperMissing).call(depth0, (depth0 != null ? depth0.foreign_vat : depth0), 0, {"name":"equal","hash":{},"fn":this.program(2, data),"inverse":this.noop,"data":data}));
  if (stack1 != null) { buffer += stack1; }
  buffer += ">Nee</option>\n      </select>\n    </div>\n";
  stack1 = ((helpers.equal || (depth0 && depth0.equal) || helperMissing).call(depth0, (depth0 != null ? depth0.category : depth0), "INSURANCE", {"name":"equal","hash":{},"fn":this.program(4, data),"inverse":this.noop,"data":data}));
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = ((helpers.equal || (depth0 && depth0.equal) || helperMissing).call(depth0, (depth0 != null ? depth0.category : depth0), "CUSTOMER", {"name":"equal","hash":{},"fn":this.program(6, data),"inverse":this.noop,"data":data}));
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = ((helpers.equal || (depth0 && depth0.equal) || helperMissing).call(depth0, (depth0 != null ? depth0.category : depth0), "COLLECTOR", {"name":"equal","hash":{},"fn":this.program(6, data),"inverse":this.noop,"data":data}));
  if (stack1 != null) { buffer += stack1; }
  return buffer + "\n\n\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_paid_cash || (depth0 != null ? depth0.amount_paid_cash : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_paid_cash","hash":{},"data":data}) : helper)))
    + "\" name=\"payment_detail_paid_cash[]\" ></div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_paid_bankdeposit || (depth0 != null ? depth0.amount_paid_bankdeposit : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_paid_bankdeposit","hash":{},"data":data}) : helper)))
    + "\" name=\"payment_detail_paid_bankdeposit[]\"></div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_paid_maestro || (depth0 != null ? depth0.amount_paid_maestro : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_paid_maestro","hash":{},"data":data}) : helper)))
    + "\" name=\"payment_detail_maestro[]\"></div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_paid_visa || (depth0 != null ? depth0.amount_paid_visa : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_paid_visa","hash":{},"data":data}) : helper)))
    + "\" name=\"payment_detail_visa[]\"></div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\">\n        <input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_unpaid_excl_vat || (depth0 != null ? depth0.amount_unpaid_excl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_unpaid_excl_vat","hash":{},"data":data}) : helper)))
    + "\" name=\"payment_detail_amount_unpaid_excl_vat[]\" readonly=\"readonly\" style=\"background: #F0F0F0;\">\n    </div>\n    <div style=\"float: left; width:10%;\">\n      <input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_unpaid_incl_vat || (depth0 != null ? depth0.amount_unpaid_incl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_unpaid_incl_vat","hash":{},"data":data}) : helper)))
    + "\" name=\"payment_detail_amount_unpaid_incl_vat[]\" readonly=\"readonly\" style=\"background: #F0F0F0;\">\n    </div>\n</div>\n";
},"2":function(depth0,helpers,partials,data) {
  return "selected=\"selected\"";
  },"4":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" id=\"paymentdetail-insurance-field-amount-excl-vat\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_excl_vat || (depth0 != null ? depth0.amount_excl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_excl_vat","hash":{},"data":data}) : helper)))
    + "\" name=\"payment_detail_amount_excl_vat[]\"></div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" id=\"paymentdetail-insurance-field-amount-incl-vat\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_incl_vat || (depth0 != null ? depth0.amount_incl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_incl_vat","hash":{},"data":data}) : helper)))
    + "\" name=\"payment_detail_amount_incl_vat[]\"></div>\n";
},"6":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_excl_vat || (depth0 != null ? depth0.amount_excl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_excl_vat","hash":{},"data":data}) : helper)))
    + "\" name=\"payment_detail_amount_excl_vat[]\" readonly=\"readonly\" style=\"background: #F0F0F0;\"></div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_incl_vat || (depth0 != null ? depth0.amount_incl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_incl_vat","hash":{},"data":data}) : helper)))
    + "\" name=\"payment_detail_amount_incl_vat[]\" readonly=\"readonly\" style=\"background: #F0F0F0;\"></div>\n";
},"8":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "<div class=\"form-item-vertical\" style=\"background: #F0F0F0;\" >\n    <div style=\"float: left; width:10%; padding-right: 3px; padding-top:5px;\">\n\n    </div>\n    <div style=\"float: left; width:10%; padding-right: 3px; padding-top: 10px; font-size: 1.4em;\">\n        <strong>TOTAAL:</strong>\n    </div>\n\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_excl_vat || (depth0 != null ? depth0.amount_excl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_excl_vat","hash":{},"data":data}) : helper)))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0;\"></div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_incl_vat || (depth0 != null ? depth0.amount_incl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_incl_vat","hash":{},"data":data}) : helper)))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0;\"></div>\n\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_paid_cash || (depth0 != null ? depth0.amount_paid_cash : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_paid_cash","hash":{},"data":data}) : helper)))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0;\"></div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_paid_bankdeposit || (depth0 != null ? depth0.amount_paid_bankdeposit : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_paid_bankdeposit","hash":{},"data":data}) : helper)))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0;\"></div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_paid_maestro || (depth0 != null ? depth0.amount_paid_maestro : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_paid_maestro","hash":{},"data":data}) : helper)))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0;\"></div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\"><input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_paid_visa || (depth0 != null ? depth0.amount_paid_visa : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_paid_visa","hash":{},"data":data}) : helper)))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0;\"></div>\n    <div style=\"float: left; width:10%; padding-right: 3px;\">\n        <input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_unpaid_excl_vat || (depth0 != null ? depth0.amount_unpaid_excl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_unpaid_excl_vat","hash":{},"data":data}) : helper)))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0;\">\n    </div>\n    <div style=\"float: left; width:10%;\">\n        <input type=\"text\" class=\"paymentdetail-field\" value=\""
    + escapeExpression(((helper = (helper = helpers.amount_unpaid_incl_vat || (depth0 != null ? depth0.amount_unpaid_incl_vat : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"amount_unpaid_incl_vat","hash":{},"data":data}) : helper)))
    + "\" readonly=\"readonly\" style=\"background: #F0F0F0;\">\n    </div>\n</div>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers.each.call(depth0, (depth0 != null ? depth0.details : depth0), {"name":"each","hash":{},"fn":this.program(1, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['with'].call(depth0, (depth0 != null ? depth0.total : depth0), {"name":"with","hash":{},"fn":this.program(8, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"useData":true});

this["Handlebars"]["Templates"]["attachment/overview"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
  var helper, helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression, functionType="function";
  return "  <tr>\n    <td>"
    + escapeExpression(((helpers.inc || (depth0 && depth0.inc) || helperMissing).call(depth0, (data && data.index), {"name":"inc","hash":{},"data":data})))
    + ".</td>\n    <td><i class=\"fa fa-file-o\"></i></td>\n    <td style=\"text-align: left;\">"
    + escapeExpression(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"name","hash":{},"data":data}) : helper)))
    + "</td>\n    <td><a href=\"/fast_dossier/document/"
    + escapeExpression(((helper = (helper = helpers.id || (depth0 != null ? depth0.id : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"id","hash":{},"data":data}) : helper)))
    + "\"><i class=\"fa fa-download\"> Download</i></a>\n    <td><a href=\"#\" class=\"attachment-delete-link\" data-docid=\""
    + escapeExpression(((helper = (helper = helpers.id || (depth0 != null ? depth0.id : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"id","hash":{},"data":data}) : helper)))
    + "\"><i class=\"fa fa-trash\"> Verwijder</i></a>\n    </td>\n  </tr>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
  var stack1, buffer = "<table>\n  <thead>\n      <tr>\n        <th>#</th>\n        <th>&nbsp;</th>\n        <th>Naam</th>\n        <th>&nbsp;</th>\n        <th>&nbsp;</th>\n      </tr>\n  </thead>\n  <tbody>\n";
  stack1 = helpers.each.call(depth0, (depth0 != null ? depth0.attachments : depth0), {"name":"each","hash":{},"fn":this.program(1, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer + "  </tbody>\n</table>\n";
},"useData":true});

this["Handlebars"]["Templates"]["causer/info"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
  return "<div class=\"has_content\">\n";
  },"3":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.last_name : depth0), {"name":"if","hash":{},"fn":this.program(1, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"5":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "      <div>"
    + escapeExpression(((helper = (helper = helpers.company_name || (depth0 != null ? depth0.company_name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"company_name","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"7":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.last_name : depth0), {"name":"if","hash":{},"fn":this.program(8, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"8":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.first_name : depth0), {"name":"if","hash":{},"fn":this.program(9, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"9":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "            <div>"
    + escapeExpression(((helper = (helper = helpers.first_name || (depth0 != null ? depth0.first_name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"first_name","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.last_name || (depth0 != null ? depth0.last_name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"last_name","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"11":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.street_number : depth0), {"name":"if","hash":{},"fn":this.program(12, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"12":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "        <div>"
    + escapeExpression(((helper = (helper = helpers.street || (depth0 != null ? depth0.street : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.street_number || (depth0 != null ? depth0.street_number : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street_number","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.street_pobox || (depth0 != null ? depth0.street_pobox : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street_pobox","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"14":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.zip : depth0), {"name":"if","hash":{},"fn":this.program(15, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"15":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "        <div>"
    + escapeExpression(((helper = (helper = helpers.zip || (depth0 != null ? depth0.zip : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"zip","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.city || (depth0 != null ? depth0.city : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"city","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"17":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "      <div>"
    + escapeExpression(((helper = (helper = helpers.country || (depth0 != null ? depth0.country : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"country","hash":{},"data":data}) : helper)))
    + " </div>\n";
},"19":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "      <div>T: "
    + escapeExpression(((helper = (helper = helpers.phone || (depth0 != null ? depth0.phone : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"phone","hash":{},"data":data}) : helper)))
    + " </div>\n";
},"21":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "    <div>E: "
    + escapeExpression(((helper = (helper = helpers.email || (depth0 != null ? depth0.email : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"email","hash":{},"data":data}) : helper)))
    + " </div>\n";
},"23":function(depth0,helpers,partials,data) {
  return "</div>\n";
  },"25":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.last_name : depth0), {"name":"if","hash":{},"fn":this.program(23, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
  var stack1, buffer = "<label>Hinderverwekker:</label>\n<div id=\"edit-nuisance-data\" class=\"nuisance-container__info\">\n\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.company_name : depth0), {"name":"if","hash":{},"fn":this.program(1, data),"inverse":this.program(3, data),"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.company_name : depth0), {"name":"if","hash":{},"fn":this.program(5, data),"inverse":this.program(7, data),"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.street : depth0), {"name":"if","hash":{},"fn":this.program(11, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.city : depth0), {"name":"if","hash":{},"fn":this.program(14, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.country : depth0), {"name":"if","hash":{},"fn":this.program(17, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.phone : depth0), {"name":"if","hash":{},"fn":this.program(19, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.email : depth0), {"name":"if","hash":{},"fn":this.program(21, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.company_name : depth0), {"name":"if","hash":{},"fn":this.program(23, data),"inverse":this.program(25, data),"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer + "\n</div>\n<a id=\"edit-nuisance-data-link\" class=\"inform-link icon--edit--small\" href=\"#causer_form\">Bewerken</a>\n";
},"useData":true});

this["Handlebars"]["Templates"]["causer/info_short"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "  <div class=\"nuisance_value\">"
    + escapeExpression(((helper = (helper = helpers.company_name || (depth0 != null ? depth0.company_name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"company_name","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"3":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.last_name : depth0), {"name":"if","hash":{},"fn":this.program(4, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"4":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.first_name : depth0), {"name":"if","hash":{},"fn":this.program(5, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"5":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "      <div class=\"nuisance_value\">"
    + escapeExpression(((helper = (helper = helpers.first_name || (depth0 != null ? depth0.first_name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"first_name","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.last_name || (depth0 != null ? depth0.last_name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"last_name","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"7":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.street_number : depth0), {"name":"if","hash":{},"fn":this.program(8, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"8":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "    <div class=\"nuisance_value\">"
    + escapeExpression(((helper = (helper = helpers.street || (depth0 != null ? depth0.street : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.street_number || (depth0 != null ? depth0.street_number : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street_number","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.street_pobox || (depth0 != null ? depth0.street_pobox : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street_pobox","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"10":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.zip : depth0), {"name":"if","hash":{},"fn":this.program(11, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"11":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "    <div class=\"nuisance_value\">"
    + escapeExpression(((helper = (helper = helpers.zip || (depth0 != null ? depth0.zip : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"zip","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.city || (depth0 != null ? depth0.city : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"city","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"13":function(depth0,helpers,partials,data) {
  return "checked";
  },"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
  var stack1, buffer = "<label>Bevestiging hinderverwekker:</label>\n<div class=\"causer_short_info_wrapper\">\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.company_name : depth0), {"name":"if","hash":{},"fn":this.program(1, data),"inverse":this.program(3, data),"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.street : depth0), {"name":"if","hash":{},"fn":this.program(7, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.city : depth0), {"name":"if","hash":{},"fn":this.program(10, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "</div>\n<div class=\"nuisance_value\">\n  <label class=\"notbold\">Hinderverwekker afwezig?</label>\n  <input type=\"checkbox\" name=\"causer_not_present\" id=\"causer_not_present\" value=\"1\" ";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.causer_not_present : depth0), {"name":"if","hash":{},"fn":this.program(13, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer + "/>\n</div>\n";
},"useData":true});

this["Handlebars"]["Templates"]["customer/info"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
  return "<div class=\"has_content\">\n";
  },"3":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.last_name : depth0), {"name":"if","hash":{},"fn":this.program(1, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"5":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "        <div>"
    + escapeExpression(((helper = (helper = helpers.company_name || (depth0 != null ? depth0.company_name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"company_name","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"7":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.last_name : depth0), {"name":"if","hash":{},"fn":this.program(8, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"8":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.first_name : depth0), {"name":"if","hash":{},"fn":this.program(9, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"9":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "                <div>"
    + escapeExpression(((helper = (helper = helpers.first_name || (depth0 != null ? depth0.first_name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"first_name","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.last_name || (depth0 != null ? depth0.last_name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"last_name","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"11":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.street_number : depth0), {"name":"if","hash":{},"fn":this.program(12, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"12":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "            <div>"
    + escapeExpression(((helper = (helper = helpers.street || (depth0 != null ? depth0.street : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.street_number || (depth0 != null ? depth0.street_number : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street_number","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.street_pobox || (depth0 != null ? depth0.street_pobox : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street_pobox","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"14":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.zip : depth0), {"name":"if","hash":{},"fn":this.program(15, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"15":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "            <div>"
    + escapeExpression(((helper = (helper = helpers.zip || (depth0 != null ? depth0.zip : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"zip","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.city || (depth0 != null ? depth0.city : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"city","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"17":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "        <div>"
    + escapeExpression(((helper = (helper = helpers.country || (depth0 != null ? depth0.country : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"country","hash":{},"data":data}) : helper)))
    + " </div>\n";
},"19":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "        <div>T: "
    + escapeExpression(((helper = (helper = helpers.phone || (depth0 != null ? depth0.phone : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"phone","hash":{},"data":data}) : helper)))
    + " </div>\n";
},"21":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "        <div>E: "
    + escapeExpression(((helper = (helper = helpers.email || (depth0 != null ? depth0.email : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"email","hash":{},"data":data}) : helper)))
    + " </div>\n";
},"23":function(depth0,helpers,partials,data) {
  return "</div>\n";
  },"25":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.last_name : depth0), {"name":"if","hash":{},"fn":this.program(23, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
  var stack1, buffer = "<label>Facturatiegegevens:</label>\n<div id=\"edit-invoice-data\" class=\"facturation-container__info\">\n\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.company_name : depth0), {"name":"if","hash":{},"fn":this.program(1, data),"inverse":this.program(3, data),"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.company_name : depth0), {"name":"if","hash":{},"fn":this.program(5, data),"inverse":this.program(7, data),"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.street : depth0), {"name":"if","hash":{},"fn":this.program(11, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.city : depth0), {"name":"if","hash":{},"fn":this.program(14, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.country : depth0), {"name":"if","hash":{},"fn":this.program(17, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.phone : depth0), {"name":"if","hash":{},"fn":this.program(19, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.email : depth0), {"name":"if","hash":{},"fn":this.program(21, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.company_name : depth0), {"name":"if","hash":{},"fn":this.program(23, data),"inverse":this.program(25, data),"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer + "\n                </div>\n<a id=\"edit-invoice-data-link\" class=\"inform-link icon--edit--small\" href=\"#customer_form\">Bewerken</a>\n";
},"useData":true});

this["Handlebars"]["Templates"]["depot/info"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
  return "<div class=\"has_content\">\n";
  },"3":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "    <div>"
    + escapeExpression(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"name","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"5":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "    <div>"
    + escapeExpression(((helper = (helper = helpers.street || (depth0 != null ? depth0.street : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.street_number || (depth0 != null ? depth0.street_number : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street_number","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.street_pobox || (depth0 != null ? depth0.street_pobox : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"street_pobox","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"7":function(depth0,helpers,partials,data) {
  var helper, functionType="function", helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;
  return "    <div>"
    + escapeExpression(((helper = (helper = helpers.zip || (depth0 != null ? depth0.zip : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"zip","hash":{},"data":data}) : helper)))
    + " "
    + escapeExpression(((helper = (helper = helpers.city || (depth0 != null ? depth0.city : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"city","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"9":function(depth0,helpers,partials,data) {
  return "</div>\n";
  },"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
  var stack1, buffer = "<label>Depot:</label>\n<div id=\"edit-depot-data\" class=\"depot-container__name\">\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.name : depth0), {"name":"if","hash":{},"fn":this.program(1, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.name : depth0), {"name":"if","hash":{},"fn":this.program(3, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.street : depth0), {"name":"if","hash":{},"fn":this.program(5, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.city : depth0), {"name":"if","hash":{},"fn":this.program(7, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  buffer += "\n";
  stack1 = helpers['if'].call(depth0, (depth0 != null ? depth0.name : depth0), {"name":"if","hash":{},"fn":this.program(9, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer + "<a id=\"edit-depot-link\" class=\"inform-link icon--edit--small\" href=\"#depot_form\">Bewerken</a>\n";
},"useData":true});

this["Handlebars"]["Templates"]["email/overview"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
  var helper, helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression, functionType="function";
  return "    <div class=\"email-item\">\n        <h2>Email "
    + escapeExpression(((helpers.inc || (depth0 && depth0.inc) || helperMissing).call(depth0, (data && data.index), {"name":"inc","hash":{},"data":data})))
    + "</h2>\n        <div class=\"email-item-content\">\n            <div class=\"email-item-subject\">"
    + escapeExpression(((helper = (helper = helpers.subject || (depth0 != null ? depth0.subject : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"subject","hash":{},"data":data}) : helper)))
    + "</div>\n            <div class=\"email-item-message\">"
    + escapeExpression(((helper = (helper = helpers.message || (depth0 != null ? depth0.message : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"message","hash":{},"data":data}) : helper)))
    + "</div>\n            "
    + escapeExpression(((helper = (helper = helpers.cd || (depth0 != null ? depth0.cd : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"cd","hash":{},"data":data}) : helper)))
    + " - "
    + escapeExpression(((helper = (helper = helpers.cd_by || (depth0 != null ? depth0.cd_by : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"cd_by","hash":{},"data":data}) : helper)))
    + "\n        </div>\n    </div>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers.each.call(depth0, (depth0 != null ? depth0.emails : depth0), {"name":"each","hash":{},"fn":this.program(1, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"useData":true});

this["Handlebars"]["Templates"]["nota/overview"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
  var helper, helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression, functionType="function";
  return "    <div class=\"nota-item\">\n        <h2>Nota "
    + escapeExpression(((helpers.inc || (depth0 && depth0.inc) || helperMissing).call(depth0, (data && data.index), {"name":"inc","hash":{},"data":data})))
    + "</h2>\n        <div class=\"nota-item-content\">\n            <div class=\"nota-item-message\">"
    + escapeExpression(((helper = (helper = helpers.message || (depth0 != null ? depth0.message : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"message","hash":{},"data":data}) : helper)))
    + "</div>\n            "
    + escapeExpression(((helper = (helper = helpers.cd || (depth0 != null ? depth0.cd : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"cd","hash":{},"data":data}) : helper)))
    + " - "
    + escapeExpression(((helper = (helper = helpers.cd_by || (depth0 != null ? depth0.cd_by : depth0)) != null ? helper : helperMissing),(typeof helper === functionType ? helper.call(depth0, {"name":"cd_by","hash":{},"data":data}) : helper)))
    + "\n        </div>\n    </div>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
  var stack1, buffer = "";
  stack1 = helpers.each.call(depth0, (depth0 != null ? depth0.notas : depth0), {"name":"each","hash":{},"fn":this.program(1, data),"inverse":this.noop,"data":data});
  if (stack1 != null) { buffer += stack1; }
  return buffer;
},"useData":true});
<% if(countJS(caseCustomFieldDetails)) { %>
<div class="d-flex create_custom_fld mtop10">
        <% for(var caseCFValue in caseCustomFieldDetails) {
         var caseCustomFieldDetail = caseCustomFieldDetails[caseCFValue]; %>        
    <div class="field_wrapper nofloat_wrapper  <% if((caseCustomFieldDetail.CustomField.field_type) == 6){ %>width-50<% } %>">
		<div class="auto_label_choice">
        <% if((caseCustomFieldDetail.CustomField.field_type) == 6){ %>
            <textarea class="CS_value" name="<%= caseCustomFieldDetail.CustomField.label %>" data-id="<%= caseCustomFieldDetail.CustomField.id %>" placeholder="<%= caseCustomFieldDetail.CustomField.placeholder %>" data-isRequired="<%= caseCustomFieldDetail.CustomField.is_required %>" data-fieldType="<%= caseCustomFieldDetail.CustomField.field_type %>"><% if(caseCustomFieldDetail.CustomFieldValue) { %><%= caseCustomFieldDetail.CustomFieldValue.value %><% } %></textarea>         
        <% } else { %>
            <input class="CS_value <% if((caseCustomFieldDetail.CustomField.field_type) == 3) { %>custom_field_datpicker<% } %>" autocomplete="off" name="<%= caseCustomFieldDetail.CustomField.label %>" data-id="<%= caseCustomFieldDetail.CustomField.id %>" type="<% if((caseCustomFieldDetail.CustomField.field_type) == 2) { %>number<% } else { %>text<% } %>" value="<% if(caseCustomFieldDetail.CustomFieldValue) { %><%= caseCustomFieldDetail.CustomFieldValue.value %><% } %>" placeholder="<%= caseCustomFieldDetail.CustomField.placeholder %>" data-isRequired="<%= caseCustomFieldDetail.CustomField.is_required %>" data-fieldType="<%= caseCustomFieldDetail.CustomField.field_type %>" />       
         <% } %>
          <div class="field_placeholder <% if((caseCustomFieldDetail.CustomField.is_required) == 1){ %>mark_mandatory<% } %>"><span><%= caseCustomFieldDetail.CustomField.label %></span></div>
        </div>
    </div>
    <%  } %>
</div>
<% } %>
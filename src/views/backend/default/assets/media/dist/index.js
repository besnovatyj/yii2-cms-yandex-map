var s=class{constructor(t,e={}){this.pickerWrapper=null;this.presetColors=[{name:"Red",value:"#FF0000"},{name:"Orange",value:"#FFA500"},{name:"Yellow",value:"#FFFF00"},{name:"Green",value:"#00FF00"},{name:"Blue",value:"#0000FF"},{name:"Purple",value:"#800080"},{name:"Pink",value:"#FFC0CB"},{name:"Gray",value:"#808080"},{name:"Black",value:"#000000"},{name:"White",value:"#FFFFFF"},{name:"Brown",value:"#A52A2A"},{name:"Cyan",value:"#00FFFF"}];this.inputElement=t,this.config=e,this.currentColor=e.initialColor||t.value||"#808080",this.init()}init(){this.inputElement.type="hidden",this.createPickerUI(),this.updateColor(this.currentColor)}createPickerUI(){this.pickerWrapper=document.createElement("div"),this.pickerWrapper.className="color-picker-wrapper";let t=document.createElement("button");t.type="button",t.className="color-picker-preview",t.style.backgroundColor=this.currentColor,t.setAttribute("aria-label","Open color picker");let e=document.createElement("div");e.className="color-picker-dropdown";let a=document.createElement("div");a.className="color-picker-hex-input-group";let o=document.createElement("label");o.textContent="HEX:",o.className="color-picker-hex-label";let i=document.createElement("input");i.type="text",i.className="color-picker-hex-input form-control form-control-sm",i.value=this.currentColor,i.maxLength=7,i.placeholder="#000000",a.appendChild(o),a.appendChild(i);let r=document.createElement("div");r.className="color-picker-palette",this.presetColors.forEach(l=>{let n=document.createElement("button");n.type="button",n.className="color-picker-preset",n.style.backgroundColor=l.value,n.setAttribute("title",l.name),n.setAttribute("data-color",l.value),r.appendChild(n)}),e.appendChild(a),e.appendChild(r),this.pickerWrapper.appendChild(t),this.pickerWrapper.appendChild(e),this.inputElement.parentElement?.insertBefore(this.pickerWrapper,this.inputElement.nextSibling),this.attachEventListeners(t,e,i,r)}attachEventListeners(t,e,a,o){t.addEventListener("click",i=>{i.preventDefault(),i.stopPropagation(),e.classList.toggle("show")}),document.addEventListener("click",i=>{this.pickerWrapper&&!this.pickerWrapper.contains(i.target)&&e.classList.remove("show")}),a.addEventListener("input",()=>{let i=a.value.trim();this.isValidHex(i)&&(this.updateColor(i),t.style.backgroundColor=i)}),a.addEventListener("blur",()=>{let i=a.value.trim();this.isValidHex(i)||(a.value=this.currentColor)}),o.addEventListener("click",i=>{let r=i.target;if(r.classList.contains("color-picker-preset")){let l=r.getAttribute("data-color");l&&(this.updateColor(l),t.style.backgroundColor=l,a.value=l,e.classList.remove("show"))}})}updateColor(t){this.currentColor=t,this.inputElement.value=t;let e=new Event("change",{bubbles:!0});this.inputElement.dispatchEvent(e),this.config.onChange&&this.config.onChange(t)}isValidHex(t){return/^#[0-9A-Fa-f]{6}$/.test(t)||/^#[0-9A-Fa-f]{3}$/.test(t)}getColor(){return this.currentColor}setColor(t){if(this.isValidHex(t)&&(this.updateColor(t),this.pickerWrapper)){let e=this.pickerWrapper.querySelector(".color-picker-preview"),a=this.pickerWrapper.querySelector(".color-picker-hex-input");e&&(e.style.backgroundColor=t),a&&(a.value=t)}}destroy(){this.pickerWrapper&&this.pickerWrapper.parentElement&&this.pickerWrapper.parentElement.removeChild(this.pickerWrapper),this.inputElement.type="text"}};var c=class{constructor(t,e){this.rowIndex=0;this.colorPickers=new Map;this.locationData=null;this.mapName="";this.blockElement=t,this.config=e;let a=this.blockElement.querySelector(".tabular-rows");if(!a)throw new Error("Rows container not found");this.rowsContainer=a,this.calculateRowIndex(),this.initializeExistingRows(),this.attachEventListeners(),this.extractLocationData(),this.extractMapName()}calculateRowIndex(){let t=this.rowsContainer.querySelectorAll(".tabular-row");this.rowIndex=t.length}initializeExistingRows(){this.rowsContainer.querySelectorAll(".tabular-row").forEach((e,a)=>{let o=e.querySelector('input[type="color"], input[name*="color"]');if(o){let i=new s(o);this.colorPickers.set(a,i)}})}attachEventListeners(){this.blockElement.addEventListener("click",t=>{let e=t.target;if(e.closest(".tabular-add-btn")&&(t.preventDefault(),this.addRow()),e.closest(".tabular-del-btn")){t.preventDefault();let a=e.closest(".tabular-row");a&&this.deleteRow(a)}if(e.closest(".tabular-autofill-btn")){t.preventDefault();let a=e.closest(".tabular-row");a&&this.autoFillRow(a)}}),this.rowsContainer.addEventListener("input",t=>{let e=t.target;e.tagName==="INPUT"&&this.validateField(e)})}addRow(){let t=this.createNewRow();t.style.opacity="0",this.rowsContainer.appendChild(t),requestAnimationFrame(()=>{t.style.transition="opacity 0.3s ease-in",t.style.opacity="1"});let e=t.querySelector('input[name*="color"]');if(e){let a=new s(e);this.colorPickers.set(this.rowIndex,a)}this.rowIndex++}createNewRow(){let t=document.createElement("div");return t.className="row tabular-row mb-3",t.innerHTML=`
            <div class="col-md-2">
                <div class="form-group field-markerform-${this.rowIndex}-latitude">
                    <label class="form-label" for="markerform-${this.rowIndex}-latitude">Latitude</label>
                    <input type="text" id="markerform-${this.rowIndex}-latitude"
                           class="form-control"
                           name="${this.config.namePrefix}[${this.rowIndex}][latitude]"
                           placeholder="0.000000"
                           data-validation="latitude">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group field-markerform-${this.rowIndex}-longitude">
                    <label class="form-label" for="markerform-${this.rowIndex}-longitude">Longitude</label>
                    <input type="text" id="markerform-${this.rowIndex}-longitude"
                           class="form-control"
                           name="${this.config.namePrefix}[${this.rowIndex}][longitude]"
                           placeholder="0.000000"
                           data-validation="longitude">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group field-markerform-${this.rowIndex}-title">
                    <label class="form-label" for="markerform-${this.rowIndex}-title">Title</label>
                    <input type="text" id="markerform-${this.rowIndex}-title"
                           class="form-control"
                           name="${this.config.namePrefix}[${this.rowIndex}][title]"
                           maxlength="255"
                           data-validation="title">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group field-markerform-${this.rowIndex}-subtitle">
                    <label class="form-label" for="markerform-${this.rowIndex}-subtitle">SubTitle</label>
                    <input type="text" id="markerform-${this.rowIndex}-subtitle"
                           class="form-control"
                           name="${this.config.namePrefix}[${this.rowIndex}][subTitle]"
                           maxlength="255"
                           data-validation="subtitle">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group field-markerform-${this.rowIndex}-color">
                    <label class="form-label" for="markerform-${this.rowIndex}-color">Color</label>
                    <input type="color" id="markerform-${this.rowIndex}-color"
                           class="form-control"
                           name="${this.config.namePrefix}[${this.rowIndex}][color]"
                           value="#808080"
                           data-validation="color">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-1 d-flex align-items-end gap-1">
                <button type="button" class="btn btn-sm btn-info tabular-autofill-btn"
                        title="Auto-fill from Location">
                    <i class="bi bi-stars"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger tabular-del-btn">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `,t}deleteRow(t){if(this.rowsContainer.querySelectorAll(".tabular-row").length<=1){this.showNotification("Cannot delete the last row","warning");return}if(!confirm("Are you sure you want to delete this marker?"))return;let a=t.querySelector('input[name*="color"]');if(a){let o=a.name.match(/\[(\d+)\]/);if(o){let i=parseInt(o[1],10),r=this.colorPickers.get(i);r&&(r.destroy(),this.colorPickers.delete(i))}}t.style.transition="opacity 0.3s ease-out",t.style.opacity="0",setTimeout(()=>{t.remove()},300)}autoFillRow(t){if(!this.locationData){this.showNotification("Location data not available","warning");return}let e=t.querySelector('input[data-validation="latitude"]'),a=t.querySelector('input[data-validation="longitude"]'),o=t.querySelector('input[data-validation="title"]');e&&(e.value=this.locationData.latitude.toFixed(6),this.validateField(e)),a&&(a.value=this.locationData.longitude.toFixed(6),this.validateField(a)),o&&this.mapName&&(o.value=this.mapName,this.validateField(o)),this.showNotification("Data auto-filled successfully","success")}extractLocationData(){let t=document.querySelector('input[name="LocationForm[latitude]"]'),e=document.querySelector('input[name="LocationForm[longitude]"]'),a=document.querySelector('input[name="LocationForm[zoom]"]');t&&e&&a&&(this.locationData={latitude:parseFloat(t.value)||0,longitude:parseFloat(e.value)||0,zoom:parseInt(a.value,10)||1},[t,e,a].forEach(o=>{o.addEventListener("input",()=>{this.locationData&&(this.locationData.latitude=parseFloat(t.value)||0,this.locationData.longitude=parseFloat(e.value)||0,this.locationData.zoom=parseInt(a.value,10)||1)})}))}extractMapName(){let t=document.querySelector('input[name="MapForm[name]"]');t&&(this.mapName=t.value||"",t.addEventListener("input",()=>{this.mapName=t.value||""}))}validateField(t){let e=t.getAttribute("data-validation"),a=!0,o="";switch(e){case"latitude":a=this.validateLatitude(t.value),o="Latitude must be between -90 and 90";break;case"longitude":a=this.validateLongitude(t.value),o="Longitude must be between -180 and 180";break;case"color":a=this.validateColor(t.value),o="Color must be in HEX format (#000000)";break;case"title":case"subtitle":a=t.value.length<=255,o="Maximum 255 characters allowed";break}let r=t.closest(".form-group")?.querySelector(".invalid-feedback");a?(t.classList.remove("is-invalid"),t.classList.add("is-valid"),r&&(r.textContent="")):(t.classList.remove("is-valid"),t.classList.add("is-invalid"),r&&(r.textContent=o))}validateLatitude(t){let e=parseFloat(t);return!isNaN(e)&&e>=-90&&e<=90}validateLongitude(t){let e=parseFloat(t);return!isNaN(e)&&e>=-180&&e<=180}validateColor(t){return/^#[0-9A-Fa-f]{6}$/.test(t)||/^#[0-9A-Fa-f]{3}$/.test(t)}showNotification(t,e){let a=document.createElement("div");a.className=`alert alert-${e==="error"?"danger":e} alert-dismissible fade show position-fixed`,a.style.cssText="top: 20px; right: 20px; z-index: 9999; min-width: 300px;",a.innerHTML=`
            ${t}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `,document.body.appendChild(a),setTimeout(()=>{a.remove()},3e3)}validateAll(){let t=!0;return this.rowsContainer.querySelectorAll("input[data-validation]").forEach(a=>{this.validateField(a),a.classList.contains("is-invalid")&&(t=!1)}),t}getMarkerData(){let t=[];return this.rowsContainer.querySelectorAll(".tabular-row").forEach(a=>{let o=a.querySelector('input[data-validation="latitude"]'),i=a.querySelector('input[data-validation="longitude"]'),r=a.querySelector('input[data-validation="title"]'),l=a.querySelector('input[data-validation="subtitle"]'),n=a.querySelector('input[data-validation="color"]');o&&i&&t.push({latitude:parseFloat(o.value)||0,longitude:parseFloat(i.value)||0,title:r?.value||"",subTitle:l?.value||"",color:n?.value||"#808080"})}),t}};document.addEventListener("DOMContentLoaded",()=>{let u=document.querySelectorAll(".tabular-block");if(u.length===0){console.warn("No tabular blocks found on the page");return}u.forEach(t=>{try{let e={blockClass:"tabular-block",namePrefix:"MarkerForm"},a=new c(t,e),o=t.closest("form");o&&o.addEventListener("submit",i=>{if(!a.validateAll())return i.preventDefault(),alert("Please fix validation errors before submitting"),!1}),console.log("Tabular Manager initialized successfully")}catch(e){console.error("Failed to initialize Tabular Manager:",e)}})});export{s as ColorPicker,c as TabularManager};
/**
 * ColorPicker - Simple color picker component with preset palette
 *
 * @author Your Name
 * @license UNLICENSED
 */
/**
 * TabularManager - Manages dynamic tabular input for markers
 *
 * @author Your Name
 * @license UNLICENSED
 */
/**
 * Yandex Map Tabular Manager
 * Main entry point for the tabular input system
 *
 * @author Your Name
 * @license UNLICENSED
 */
//# sourceMappingURL=index.js.map

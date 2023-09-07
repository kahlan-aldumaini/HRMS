import{M as x,_ as F,D as v,S as U,F as S}from"./FormDropDown-d545c5d5.js";import{_ as T}from"./BlueButton-a8ab83bf.js";import{F as L}from"./FormInput-9abe307f.js";import{S as N}from"./SideCard-92ea97fb.js";import{A as j}from"./AppLayout-e055a3fb.js";import{_ as H,I as A}from"./_plugin-vue_export-helper-d97591f4.js";import{T as E,k as p,r as d,o as _,c as D,b as l,f as n,g as r,t as h,a as o,F as M,l as y,d as q}from"./app-65af30ef.js";import"./DropdownList-9b3ede74.js";const z={name:"Index",layout:j,components:{Model:x,SideCard:N,TableCard:F,Icon:A,BlueButton:T,DangerButton:v,SecondaryButton:U,FormInput:L,FormDropDown:S},data(){return{showBransh:!1,showDepartment:!1,showManagement:!1,showUnit:!1,showDelete:!1,editId:null,editName:null,branshes:[],managements:[],units:[],form:E({bransh:null,management:null,department:null,unit:null}),showData:[{id:1,name:"ladkjf"}],sideCards:[{id:1,label:"الفرع",isChild:!0,back:()=>{this.form.reset(),this.sideCards[0].isChild=!1},show:async()=>{this.sideCards[0].isChild=!0,this.sideCards[1].isChild=!1,this.sideCards[2].isChild=!1,this.sideCards[3].isChild=!1,await this.getBransh(),this.showData=this.branshes}},{id:2,label:"الادارات",isChild:!1,back:()=>{this.form.reset(),this.sideCards[1].isChild=!1},show:async()=>{this.sideCards[1].isChild=!0,this.sideCards[0].isChild=!1,this.sideCards[2].isChild=!1,this.sideCards[3].isChild=!1,await this.getManagment(),this.showData=this.managements}},{id:3,label:"القسم",isChild:!1,back:()=>{this.form.reset(),this.sideCards[2].isChild=!1},show:async()=>{this.sideCards[2].isChild=!0,this.sideCards[1].isChild=!1,this.sideCards[0].isChild=!1,this.sideCards[3].isChild=!1,await this.getDepartment(),this.showData=this.departments}},{id:4,label:"الوحدات",isChild:!1,back:()=>{this.form.reset(),this.sideCards[3].isChild=!1},show:async()=>{this.sideCards[3].isChild=!0,this.sideCards[1].isChild=!1,this.sideCards[2].isChild=!1,this.sideCards[0].isChild=!1,await this.getUnit(),this.showData=this.units}}]}},async created(){await this.getBransh(),this.showData=this.branshes},methods:{async getBransh(){await p.get("/get_bransh").then(e=>this.branshes=e.data)},async getManagment(e=0){e&&(this.form.bransh=e),await p.get("/get_management/"+e).then(t=>this.managements=t.data)},async getDepartment(e=0){e&&(this.form.management=e),await p.get("/get_department/"+e).then(t=>this.departments=t.data)},async getUnit(e=0){e&&(this.form.department=e),await p.get("/get_unit/"+e).then(t=>this.units=t.data)},submit(){this.form.post("/store_management/"+this.editId,{onSuccess:()=>{this.toast("",`تم ${this.editId?"تعديل":"انشاء"} ${this.sideCards.find(e=>e.isChild).label} بنجاح.`),this.form.reset(),this.hideBranshModel(),this.hideDepartmentModel(),this.hideManagementModel(),this.hideUnitModel(),this.sideCards.find(e=>e.isChild).show()}})},hideBranshModel(){this.form.reset(),this.showBransh=!1,this.editId=null},hideDepartmentModel(){this.form.reset(),this.showDepartment=!1,this.editId=null},hideManagementModel(){this.form.reset(),this.showManagement=!1,this.editId=null},hideUnitModel(){this.showUnit=!1,this.editId=null},hideDeleteModel(){this.form.reset(),this.showDelete=!1,this.editId=null},showBranshModel(e=null){this.showBransh=!0,this.editId=e,e&&(this.form.bransh=this.branshes.find(t=>t.id==e).name)},async showDepartmentModel(e=null){this.showDepartment=!0,this.editId=e,e&&(await this.getManagment(),this.form.bransh=this.managements.find(t=>t.id==this.showData.find(m=>m.id==e).management_id).bransh_id,await this.getManagment(this.form.bransh),this.form.management=this.showData.find(t=>t.id==e).management_id,this.form.department=this.showData.find(t=>t.id==e).name)},showManagementModel(e=null){this.showManagement=!0,this.editId=e,e&&(this.form.bransh=this.showData.find(t=>t.id==e).bransh_id,this.form.management=this.showData.find(t=>t.id==e).name)},async showUnitModel(e=null){if(this.showUnit=!0,this.editId=e,e){await this.getDepartment();let t=this.departments.find(f=>f.id==this.showData.find(s=>s.id==e).department_id);this.form.department=t.id,await this.getDepartment(t.management_id),await this.getManagment();let m=this.managements.find(f=>f.id==t.management_id);this.form.management=m.id,await this.getManagment(m.bransh_id),this.form.bransh=m.bransh_id,this.form.unit=this.showData.find(f=>f.id==e).name}},showDeleteModel(e){this.showDelete=!0,this.editId=e.id,this.editName=e.name},showModel(e=null){const t=this.sideCards.find(m=>m.isChild).id;t==1?this.showBranshModel(e):t==3?this.showDepartmentModel(e):t==2?this.showManagementModel(e):this.showUnitModel(e)},destroy(){this.form.delete("/destroy_management/"+this.editId+"/"+this.sideCards.find(e=>e.isChild).id,{onSuccess:()=>{this.toast("",`تم حذف ${this.sideCards.find(e=>e.isChild).label} بنجاح.`),this.form.reset(),this.hideDeleteModel(),this.sideCards.find(e=>e.isChild).show()}})}}},G={class:"grid w-full grid-cols-2 gap-2"},J={class:"grid w-full grid-cols-2 gap-2"},K={class:"grid w-full grid-cols-2 gap-2"},O={class:"grid w-full grid-cols-2 gap-2"},P={class:"px-4"},Q={class:"px-1 font-semibold text-red-500"},R={class:"grid grid-cols-2 gap-4 w-full"},W={class:"flex justify-between w-full h-full bg-gray-200"},X={class:"w-1/5 px-2"},Y={class:"w-4/5 px-2"},Z={class:"flex justify-between w-full item-center"},$={class:"text-xl text-center"},ee={class:"w-52"},se=o("th",null,"#",-1),te=o("th",{class:"h-10"},"الاسم",-1),ie=o("th",null,"خيارات",-1),le=["innerHTML"],ne=["innerHTML"],ae={class:"flex items-center h-full py-2 justify-evenly"};function oe(e,t,m,f,s,a){const b=d("FormInput"),C=d("SecondaryButton"),g=d("DangerButton"),w=d("Model"),u=d("FormDropDown"),V=d("SideCard"),B=d("BlueButton"),k=d("Icon"),I=d("TableCard");return _(),D(M,null,[l(w,{show:s.showBransh,hide:a.hideBranshModel},{title:n(()=>[r(h(s.editId?"تعديل الفرع":"انشاء الفرع"),1)]),footer:n(()=>[o("div",G,[l(C,{onClick:a.submit},{default:n(()=>[r(" حفظ ")]),_:1},8,["onClick"]),l(g,{onClick:a.hideBranshModel},{default:n(()=>[r(" الغاء ")]),_:1},8,["onClick"])])]),default:n(()=>[l(b,{label:"الفرع",type:"text",modelValue:s.form.bransh,"onUpdate:modelValue":t[0]||(t[0]=i=>s.form.bransh=i),error:s.form.errors.bransh},null,8,["modelValue","error"])]),_:1},8,["show","hide"]),l(w,{show:s.showDepartment,hide:a.hideDepartmentModel},{title:n(()=>[r(h(s.editId?"تعديل القسم":"انشاء القسم"),1)]),footer:n(()=>[o("div",J,[l(C,{onClick:a.submit},{default:n(()=>[r(" حفظ ")]),_:1},8,["onClick"]),l(g,{onClick:a.hideDepartmentModel},{default:n(()=>[r(" الغاء ")]),_:1},8,["onClick"])])]),default:n(()=>[l(u,{label:"الفروع",selectData:s.branshes,modelValue:s.form.bransh,"onUpdate:modelValue":t[1]||(t[1]=i=>s.form.bransh=i),error:s.form.errors.bransh,selectFun:a.getManagment},null,8,["selectData","modelValue","error","selectFun"]),l(u,{label:"الادارة",selectData:s.managements,modelValue:s.form.management,"onUpdate:modelValue":t[2]||(t[2]=i=>s.form.management=i),error:s.form.errors.management,selectFun:i=>{}},null,8,["selectData","modelValue","error","selectFun"]),l(b,{label:"القسم",type:"text",modelValue:s.form.department,"onUpdate:modelValue":t[3]||(t[3]=i=>s.form.department=i),error:s.form.errors.department},null,8,["modelValue","error"])]),_:1},8,["show","hide"]),l(w,{show:s.showManagement,hide:a.hideManagementModel},{title:n(()=>[r(h(s.editId?"تعديل الادارة":"انشاء الادارة"),1)]),footer:n(()=>[o("div",K,[l(C,{onClick:a.submit},{default:n(()=>[r(" حفظ ")]),_:1},8,["onClick"]),l(g,{onClick:a.hideManagementModel},{default:n(()=>[r(" الغاء ")]),_:1},8,["onClick"])])]),default:n(()=>[l(u,{label:"الفرع",selectData:s.branshes,modelValue:s.form.bransh,"onUpdate:modelValue":t[4]||(t[4]=i=>s.form.bransh=i),error:s.form.errors.bransh,selectFun:i=>{}},null,8,["selectData","modelValue","error","selectFun"]),l(b,{label:"الادارة",type:"text",modelValue:s.form.management,"onUpdate:modelValue":t[5]||(t[5]=i=>s.form.management=i),error:s.form.errors.management},null,8,["modelValue","error"])]),_:1},8,["show","hide"]),l(w,{show:s.showUnit,hide:a.hideUnitModel},{title:n(()=>[r(h(s.editId?"تعديل الوحدة":"انشاء الوحدة"),1)]),footer:n(()=>[o("div",O,[l(C,{onClick:a.submit},{default:n(()=>[r(" حفظ ")]),_:1},8,["onClick"]),l(g,{onClick:a.hideManagementModel},{default:n(()=>[r(" الغاء ")]),_:1},8,["onClick"])])]),default:n(()=>[l(u,{label:"الفروع",selectData:s.branshes,modelValue:s.form.bransh,"onUpdate:modelValue":t[6]||(t[6]=i=>s.form.bransh=i),error:s.form.errors.bransh,selectFun:a.getManagment},null,8,["selectData","modelValue","error","selectFun"]),l(u,{label:"الادارة",selectData:s.managements,modelValue:s.form.management,"onUpdate:modelValue":t[7]||(t[7]=i=>s.form.management=i),error:s.form.errors.management,selectFun:a.getDepartment},null,8,["selectData","modelValue","error","selectFun"]),l(u,{label:"الاقسام",selectData:e.departments,modelValue:s.form.department,"onUpdate:modelValue":t[8]||(t[8]=i=>s.form.department=i),error:s.form.errors.department,selectFun:i=>{}},null,8,["selectData","modelValue","error","selectFun"]),l(b,{label:"الوحدة",type:"text",modelValue:s.form.unit,"onUpdate:modelValue":t[9]||(t[9]=i=>s.form.unit=i),error:s.form.errors.unit},null,8,["modelValue","error"])]),_:1},8,["show","hide"]),l(w,{show:s.showDelete,hide:a.hideDeleteModel},{title:n(()=>[r(" حذف "+h(s.sideCards.find(i=>i.isChild).label),1)]),footer:n(()=>[o("div",R,[l(g,{onClick:a.destroy},{default:n(()=>[r(" حذف ")]),_:1},8,["onClick"]),l(C,{onClick:a.hideDeleteModel},{default:n(()=>[r(" الغاء ")]),_:1},8,["onClick"])])]),default:n(()=>[o("div",P,[r(" هل انت متأكد من حذف "+h(s.sideCards.find(i=>i.isChild).label)+" ",1),o("span",Q,h(s.editName),1),r("؟ ")])]),_:1},8,["show","hide"]),o("div",W,[o("div",X,[(_(!0),D(M,null,y(s.sideCards,i=>(_(),q(V,{key:i.id,label:i.label,onBack:i.back,onShow:i.show,"is-child":!i.isChild},null,8,["label","onBack","onShow","is-child"]))),128))]),o("div",Y,[l(I,null,{header:n(()=>{var i;return[o("div",Z,[o("div",$,h((i=s.sideCards.find(c=>c.isChild))==null?void 0:i.label),1),o("div",ee,[l(B,{onClick:t[10]||(t[10]=c=>a.showModel())},{default:n(()=>[r(" اظافة "+h(s.sideCards.find(c=>c.isChild).label),1)]),_:1})])])]}),table_header:n(()=>[se,te,ie]),table_body:n(()=>[(_(!0),D(M,null,y(s.showData,i=>(_(),D("tr",{key:i.id,class:"h-8 text-center hover:bg-gray-200 hover:rounded-md"},[o("td",{innerHTML:i.id},null,8,le),o("td",{innerHTML:i.name},null,8,ne),o("td",ae,[l(k,{class:"cursor-pointer hover:text-slate-900",onClick:c=>a.showModel(i.id),icon:"carbon:edit"},null,8,["onClick"]),l(k,{class:"cursor-pointer hover:text-slate-900",icon:"carbon:trash-can",onClick:c=>a.showDeleteModel(i)},null,8,["onClick"])])]))),128))]),_:1})])])],64)}const ge=H(z,[["render",oe]]);export{ge as default};
import{_ as V}from"./BlueButton-a8ab83bf.js";import{D as q,a as D}from"./DropdownList-9b3ede74.js";import{F as $}from"./FormInput-9abe307f.js";import{_ as S}from"./_plugin-vue_export-helper-d97591f4.js";import{o,c as n,m as H,a as t,T as U,O as C,k as w,r as L,d as _,f as l,b as i,g as u,t as b,F as g,l as y,e as a,w as d,i as m,h as B}from"./app-65af30ef.js";const j={name:"FormSection",props:{label:String}},N={class:"w-full h-max px-2 py-4"},F={class:"w-full flex items-center justify-between max-h-20"},O=["innerHTML"],E=t("div",{class:"w-3/4 h-full flex items-center"},[t("div",{class:"w-full h-1 rounded-full bg-slate-500"})],-1),G={class:"w-full pt-4 px-2"},A={class:"w-full pt-4 px-2"};function I(e,r,h,M,T,k){return o(),n("div",N,[H(e.$slots,"header",{},()=>[t("div",F,[t("p",{class:"pl-2 text-2xl text-slate-700",innerHTML:h.label},null,8,O),E])]),t("div",G,[H(e.$slots,"default")]),t("div",A,[H(e.$slots,"footer")])])}const K=S(j,[["render",I]]),z={props:{employee:{type:Object,default:null}},data:()=>({branshes:[{name:"",id:0}],managment:[],department:[],groups:[],units:[],selectedSection:1,career_names:[],career_degrees:[],career_categories:[],form:U({id:null,name:null,nationality:null,unit:null,bransh:null,managment:null,department:null,phone_number:null,sex:null,birth_date:null,marital_status:null,employee_number:null,email:null,place_of_residence:null,type_of_identity:null,identity_number:null,identity_export_date:null,identity_place:null,qualification:null,qualification_type:null,qualification_from_date:null,qualification_to_date:null,group:null,group_from:null,group_to:null,career_name:null,career_degree:null,career_type:null,career_category:null,date_of_hiring:null,work_permit:null,permit_from:null,permit_to:null,retirement_age:null,service_expirateion_date:null,in_work_date:null,out_work_date:null,salary_all:null,salary_primary:null,salary_start:null,salary_end:null,salary_bank_name:null,salary_account_number:null,done:!1}),qualifications:[{id:1,name:"ثانوي",types:[{id:1,name:"ادبي"},{id:2,name:"علمي"}]},{id:1,name:"جامعي",types:[{id:1,name:"بكلريوس"},{id:2,name:"ماجستير"},{id:3,name:"دكتوراه"}]}]}),async created(){await this.getCareerNames(),await this.getBransh(),this.getGroups(),this.employee!=null&&(this.form=U({...this.employee}),await this.getManagment(this.branshes.filter(e=>e.name=this.employee.bransh)[0].id),await this.getDepartment(this.managment.filter(e=>e.name=this.employee.managment)[0].id),await this.getUnit(this.department.filter(e=>e.name=this.employee.department)[0].id),this.form.unit=this.employee.unit)},components:{FormInput:$,DropDownOption:q,DropdownList:D,BlueButton:V,FormSection:K},methods:{submit(){this.form.post("/employee",{onSuccess:()=>{this.selectedSection>=6?(this.toast("",`تم ${this.form.id!=null?"تعديل الموظف بنجاح":"انشاء الموظف بنجاح"}`),C.get("/employees")):this.selectedSection++},onError:e=>{let r=Object.keys(e),h=[];this.selectedSection==1&&(h=["name","nationality","unit","bransh","managment","department","phone_number","sex","birth_date","marital_status","employee_number","email","place_of_residence"]),this.selectedSection==2&&(h=["type_of_identity","identity_number","identity_export_date","identity_place"]),this.selectedSection==3&&(this.getCareerNames(),this.getCareerCategories(),this.getCareerDegrees(),h=["qualification","qualification_type","qualification_from_date","qualification_to_date"]),this.selectedSection==4&&(h=["career_name","career_degree","career_type","career_category","date_of_hiring","work_permit","permit_from","permit_to","retirement_age"]),this.selectedSection==5&&(h=["service_expirateion_date","in_work_date","out_work_date","group","group_from","group_to"]),this.selectedSection==6&&(h=["salary_all","salary_primary","salary_start","salary_end","salary_bank_name","salary_account_number"]),r.some(M=>h.some(T=>T==M))||this.selectedSection++}})},async getBransh(){await w.get("/get_bransh").then(e=>this.branshes=e.data)},async getManagment(e){this.form.bransh=this.branshes.find(r=>r.id==e).name,this.form.managment=null,this.form.department="",this.form.unit="",await w.get("/get_management/"+e).then(r=>this.managment=r.data)},async getDepartment(e){this.form.managment=this.managment.find(r=>r.id==e).name,this.form.department="",this.form.unit="",await w.get("/get_department/"+e).then(r=>this.department=r.data)},async getUnit(e){this.form.department=this.department.find(r=>r.id==e).name,this.form.unit="",await w.get("/get_unit/"+e).then(r=>this.units=r.data)},getUnitName(e){var r;return((r=this.units.find(h=>h.id==e))==null?void 0:r.name)||""},getToday(){return new Date().toLocaleDateString()},getGroups(){w.get("/get-groups").then(e=>{console.log("groups",e.data),this.groups=e.data}).catch(e=>console.log(e,"get groups"))},async getCareerNames(){await w.get("/get-career-name").then(e=>this.career_names=e.data)},async getCareerDegrees(){await w.get("/get-career-degrees").then(e=>this.career_degrees=e.data)},async getCareerCategories(){await w.get("/get-career-categories").then(e=>this.career_categories=e.data)}}},J={class:"grid w-full grid-cols-4 gap-2"},P={class:"block w-full mb-4"},Q=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"الفرع",-1),R={class:"px-2 border rounded-md"},W={class:"px-1"},X=["innerHTML"],Y={class:"block w-full mb-4"},Z=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"الادارة",-1),ee={class:"px-2 border rounded-md"},te={class:"px-1"},se=["innerHTML"],re={class:"block w-full mb-4"},oe=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"القسم",-1),le={class:"px-2 border rounded-md"},ne={class:"px-1"},ae=["innerHTML"],ie={class:"block w-full mb-4"},de=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"الوحدة",-1),me={class:"px-2 border rounded-md"},ue={class:"px-1"},be=["innerHTML"],fe={class:"block w-full px-2 mb-4"},ce=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"اسم الموظف",-1),_e={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},pe=["innerHTML"],he={class:"block w-full px-2 mb-4"},ge=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"رقم الموظف",-1),ye={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},ke=["innerHTML"],we={class:"grid w-full grid-cols-2 gap-2 px-2 mb-4"},xe={class:"block w-full mb-4"},ve=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"الجنس",-1),Le={class:"pl-2 border rounded-md"},Me={class:"px-1"},Te=["innerHTML"],He={class:"block w-full px-2 mb-4"},Ue=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"الجنسية",-1),Se={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Ve=["innerHTML"],qe={class:"block w-full px-2 mb-4"},De=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"تاريخ الميلاد",-1),$e={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Ce=["innerHTML"],Be={class:"block w-full mb-4"},je=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"الحالة الاجتماعية",-1),Ne={class:"px-2 border rounded-md"},Fe={class:"px-1"},Oe=["innerHTML"],Ee={class:"block w-full px-2 mb-4"},Ge=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"رقم التلفون",-1),Ae={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Ie=["innerHTML"],Ke={class:"block w-full px-2 mb-4"},ze=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"}," الايميل",-1),Je={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Pe=["innerHTML"],Qe={class:"block w-full px-2 mb-4"},Re=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"محل الاقامة",-1),We={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Xe=["innerHTML"],Ye={class:"flex items-center justify-end"},Ze={class:"flex items-center justify-center w-1/6"},et={class:"grid w-full grid-cols-4 gap-2"},tt={class:"block w-full mb-4"},st=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"نوع الهوية",-1),rt={class:"px-2 border rounded-md"},ot={class:"px-1"},lt=["innerHTML"],nt={class:"block w-full px-2 mb-4"},at=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"رقم الهوية",-1),it={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},dt=["innerHTML"],mt={class:"block w-full px-2 mb-4"},ut=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"مكان اصدار الهوية",-1),bt={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},ft=["innerHTML"],ct={class:"block w-full px-2 mb-4"},_t=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"تاريخ اصدار الهوية",-1),pt={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},ht=["innerHTML"],gt={class:"flex items-center justify-end"},yt={class:"flex w-1/3"},kt={class:"grid w-full grid-cols-4 gap-2"},wt={class:"block w-full px-2 mb-4"},xt=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"المؤهل العلمي",-1),vt={class:"px-2 border rounded-md"},Lt={class:"px-1"},Mt=["innerHTML"],Tt={class:"block w-full mb-4"},Ht=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"نوع المؤهل",-1),Ut={class:"px-2 border rounded-md"},St={class:"px-1"},Vt=["innerHTML"],qt={class:"block w-full px-2 mb-4"},Dt=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"المؤهل من تاريخ",-1),$t={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Ct=["max"],Bt=["innerHTML"],jt={class:"block w-full px-2 mb-4"},Nt=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"المؤهل الى تاريخ",-1),Ft={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Ot=["min","max"],Et=["innerHTML"],Gt={class:"flex items-center justify-end"},At={class:"flex w-1/3"},It={class:"grid w-full grid-cols-4 gap-2"},Kt={class:"block w-full px-2 mb-4"},zt=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"المسمى الوظيفي",-1),Jt={class:"px-2 border rounded-md"},Pt={class:"px-1"},Qt=["innerHTML"],Rt={class:"block w-full mb-4"},Wt=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"الدرجة الوظيفيه",-1),Xt={class:"px-2 border rounded-md"},Yt={class:"px-1"},Zt=["innerHTML"],es={class:"flex w-full px-2 mb-4"},ts={class:"block w-full mb-4"},ss=t("span",{class:"block mb-1 text-sm font-semibold"},"الفئة الوظيفيه",-1),rs={class:"pl-2 border rounded-md"},os={class:"px-1"},ls=["innerHTML"],ns={class:"block w-full mb-4"},as=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"نوع الموظف",-1),is={class:"pr-2 border rounded-md"},ds={class:"px-1"},ms=["innerHTML"],us={class:"block w-full px-2 mb-4"},bs=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"تاريخ التعيين",-1),fs={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},cs=["innerHTML"],_s={class:"block w-full px-2 mb-4"},ps=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"تصريح العمل",-1),hs={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},gs=["innerHTML"],ys={class:"block w-full px-2 mb-4"},ks=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"تصريح من",-1),ws={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},xs=["innerHTML"],vs={class:"block w-full px-2 mb-4"},Ls=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"تصريح الى",-1),Ms={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Ts=["min"],Hs=["innerHTML"],Us={class:"block w-full px-2 mb-4"},Ss=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"سن التقاعد",-1),Vs={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},qs=["innerHTML"],Ds={class:"flex items-center justify-end"},$s={class:"flex w-1/3"},Cs={class:"grid w-full grid-cols-4 gap-2"},Bs={class:"block w-full mb-4"},js=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"المجموعة",-1),Ns={class:"px-2 border rounded-md"},Fs={class:"px-1"},Os=["innerHTML"],Es={class:"block w-full px-2 mb-4"},Gs=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"من تاريخ",-1),As={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Is=["innerHTML"],Ks={class:"block w-full px-2 mb-4"},zs=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"الى تاريخ",-1),Js={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Ps=["min"],Qs=["innerHTML"],Rs={class:"block w-full px-2 mb-4"},Ws=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"تاريخ انهاء الخدمة",-1),Xs={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Ys=["innerHTML"],Zs={class:"block w-full px-2 mb-4"},er=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"سنوات الخدمة الداخلية",-1),tr={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},sr=["innerHTML"],rr={class:"block w-full px-2 mb-4"},or=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"سنوات الخدمة الخارجية",-1),lr={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},nr=["innerHTML"],ar={class:"flex items-center justify-end"},ir={class:"flex w-1/6"},dr={class:"grid w-full grid-cols-4 gap-2"},mr={class:"block w-full px-2 mb-4"},ur=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"الراتب الاساسي",-1),br={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},fr=["innerHTML"],cr={class:"block w-full px-2 mb-4"},_r=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"الراتب الشامل",-1),pr={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},hr=["innerHTML"],gr={class:"block w-full px-2 mb-4"},yr=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"من",-1),kr={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},wr=["max"],xr=["innerHTML"],vr={class:"block w-full px-2 mb-4"},Lr=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"الى",-1),Mr={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Tr=["min"],Hr=["innerHTML"],Ur={class:"block w-full px-2 mb-4"},Sr=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"اسم البنك",-1),Vr={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},qr=["innerHTML"],Dr={class:"block w-full px-2 mb-4"},$r=t("span",{class:"block mb-1 mr-4 text-sm font-semibold"},"رقم الحساب",-1),Cr={class:"flex items-center bg-white border-2 border-gray-500 rounded-md"},Br=["innerHTML"],jr={class:"flex items-center justify-end"},Nr={class:"flex w-1/6"},Fr={key:6,class:"flex items-center justify-end"},Or={class:"flex w-1/3"},Er=t("button",{type:"reset",class:"w-full py-2 mx-2 text-sm font-semibold text-white bg-red-500 rounded-full"}," الغاء ",-1);function Gr(e,r,h,M,T,k){const f=L("DropDownOption"),p=L("DropdownList"),x=L("BlueButton"),v=L("FormSection");return o(),n("form",{onSubmit:r[34]||(r[34]=B((...s)=>k.submit&&k.submit(...s),["prevent"])),class:"w-full"},[e.selectedSection==1?(o(),_(v,{key:0,label:"البيانات الشخصية"},{footer:l(()=>[t("div",Ye,[t("div",Ze,[i(x,{type:"submit"},{default:l(()=>[u(" التالي ")]),_:1})])])]),default:l(()=>[t("div",J,[t("label",P,[Q,t("div",R,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",W,b(e.form.bransh),1)]),items:l(()=>[(o(!0),n(g,null,y(e.branshes,s=>(o(),_(f,{class:"hover:bg-blue-500",select:c=>k.getManagment(s.id),key:s.id},{default:l(()=>[u(b(s.name),1)]),_:2},1032,["select"]))),128))]),_:1})]),e.form.errors.bransh!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.bransh},null,8,X)):a("",!0)]),t("label",Y,[Z,t("div",ee,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",te,b(e.form.managment),1)]),items:l(()=>[(o(!0),n(g,null,y(e.managment,s=>(o(),_(f,{class:"hover:bg-blue-500",key:s.id,select:c=>k.getDepartment(s.id)},{default:l(()=>[u(b(s.name),1)]),_:2},1032,["select"]))),128))]),_:1})]),e.form.errors.managment!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.managment},null,8,se)):a("",!0)]),t("label",re,[oe,t("div",le,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",ne,b(e.form.department),1)]),items:l(()=>[(o(!0),n(g,null,y(e.department,s=>(o(),_(f,{class:"hover:bg-blue-500",key:s.id,select:c=>k.getUnit(s.id)},{default:l(()=>[u(b(s.name),1)]),_:2},1032,["select"]))),128))]),_:1})]),e.form.errors.department!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.department},null,8,ae)):a("",!0)]),t("label",ie,[de,t("div",me,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",ue,b(k.getUnitName(e.form.unit)),1)]),items:l(()=>[(o(!0),n(g,null,y(e.units,s=>(o(),_(f,{class:"hover:bg-blue-500",key:s.id,select:c=>e.form.unit=s.id},{default:l(()=>[u(b(s.name),1)]),_:2},1032,["select"]))),128))]),_:1})]),e.form.errors.unit!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.unit},null,8,be)):a("",!0)]),t("label",fe,[ce,t("div",_e,[d(t("input",{dir:"rtl",type:"text","onUpdate:modelValue":r[0]||(r[0]=s=>e.form.name=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.name]])]),e.form.errors.name!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.name},null,8,pe)):a("",!0)]),t("label",he,[ge,t("div",ye,[d(t("input",{dir:"rtl",type:"text","onUpdate:modelValue":r[1]||(r[1]=s=>e.form.employee_number=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.employee_number]])]),e.form.errors.employee_number!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.employee_number},null,8,ke)):a("",!0)]),t("div",we,[t("label",xe,[ve,t("div",Le,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",Me,b(e.form.sex),1)]),items:l(()=>[i(f,{class:"hover:bg-blue-500",select:s=>e.form.sex="ذكر"},{default:l(()=>[u(" ذكر ")]),_:1},8,["select"]),i(f,{class:"hover:bg-blue-500",select:s=>e.form.sex="انثى"},{default:l(()=>[u(" انثى ")]),_:1},8,["select"])]),_:1})]),e.form.errors.sex!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.sex},null,8,Te)):a("",!0)]),t("label",He,[Ue,t("div",Se,[d(t("input",{dir:"rtl",type:"text","onUpdate:modelValue":r[2]||(r[2]=s=>e.form.nationality=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.nationality]])]),e.form.errors.nationality!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.nationality},null,8,Ve)):a("",!0)])]),t("label",qe,[De,t("div",$e,[d(t("input",{dir:"rtl",type:"date","onUpdate:modelValue":r[3]||(r[3]=s=>e.form.birth_date=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.birth_date]])]),e.form.errors.birth_date!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.birth_date},null,8,Ce)):a("",!0)]),t("label",Be,[je,t("div",Ne,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",Fe,b(e.form.marital_status),1)]),items:l(()=>[i(f,{class:"hover:bg-blue-500",select:s=>e.form.marital_status="اعزب"},{default:l(()=>[u(" اعزب ")]),_:1},8,["select"]),i(f,{class:"hover:bg-blue-500",select:s=>e.form.marital_status="مطلق"},{default:l(()=>[u(" مطلق ")]),_:1},8,["select"]),i(f,{class:"hover:bg-blue-500",select:s=>e.form.marital_status="ارمل"},{default:l(()=>[u(" ارمل ")]),_:1},8,["select"]),i(f,{class:"hover:bg-blue-500",select:s=>e.form.marital_status="مزوج"},{default:l(()=>[u(" مزوج ")]),_:1},8,["select"])]),_:1})]),e.form.errors.marital_status!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.marital_status},null,8,Oe)):a("",!0)]),t("label",Ee,[Ge,t("div",Ae,[d(t("input",{dir:"rtl",type:"tel","onUpdate:modelValue":r[4]||(r[4]=s=>e.form.phone_number=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.phone_number]])]),e.form.errors.phone_number!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.phone_number},null,8,Ie)):a("",!0)]),t("label",Ke,[ze,t("div",Je,[d(t("input",{dir:"rtl",type:"email","onUpdate:modelValue":r[5]||(r[5]=s=>e.form.email=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.email]])]),e.form.errors.email!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.email},null,8,Pe)):a("",!0)]),t("label",Qe,[Re,t("div",We,[d(t("input",{dir:"rtl",type:"text","onUpdate:modelValue":r[6]||(r[6]=s=>e.form.place_of_residence=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.place_of_residence]])]),e.form.errors.place_of_residence!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.place_of_residence},null,8,Xe)):a("",!0)])])]),_:1})):a("",!0),e.selectedSection==2?(o(),_(v,{key:1,label:"بيانات الهوية"},{footer:l(()=>[t("div",gt,[t("div",yt,[i(x,{type:"submit"},{default:l(()=>[u(" التالي ")]),_:1}),t("button",{onClick:r[10]||(r[10]=s=>e.selectedSection=1),type:"button",class:"w-full py-2 mx-2 text-sm font-semibold text-white rounded-full bg-slate-500"}," السابق ")])])]),default:l(()=>[t("div",et,[t("label",tt,[st,t("div",rt,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",ot,b(e.form.type_of_identity),1)]),items:l(()=>[i(f,{class:"hover:bg-blue-500",select:s=>e.form.type_of_identity="بطاقة"},{default:l(()=>[u(" بطاقة ")]),_:1},8,["select"]),i(f,{class:"hover:bg-blue-500",select:s=>e.form.type_of_identity="جواز سفر"},{default:l(()=>[u(" جواز سفر ")]),_:1},8,["select"])]),_:1})]),e.form.errors.type_of_identity!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.type_of_identity},null,8,lt)):a("",!0)]),t("label",nt,[at,t("div",it,[d(t("input",{dir:"rtl",type:"text","onUpdate:modelValue":r[7]||(r[7]=s=>e.form.identity_number=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.identity_number]])]),e.form.errors.identity_number!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.identity_number},null,8,dt)):a("",!0)]),t("label",mt,[ut,t("div",bt,[d(t("input",{dir:"rtl",type:"text","onUpdate:modelValue":r[8]||(r[8]=s=>e.form.identity_place=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.identity_place]])]),e.form.errors.identity_place!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.identity_place},null,8,ft)):a("",!0)]),t("label",ct,[_t,t("div",pt,[d(t("input",{dir:"rtl",type:"date","onUpdate:modelValue":r[9]||(r[9]=s=>e.form.identity_export_date=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.identity_export_date]])]),e.form.errors.identity_export_date!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.identity_export_date},null,8,ht)):a("",!0)])])]),_:1})):a("",!0),e.selectedSection==3?(o(),_(v,{key:2,label:"بيانات المؤهل"},{footer:l(()=>[t("div",Gt,[t("div",At,[i(x,{type:"submit"},{default:l(()=>[u(" التالي ")]),_:1}),t("button",{onClick:r[13]||(r[13]=s=>e.selectedSection=2),type:"button",class:"w-full py-2 mx-2 text-sm font-semibold text-white rounded-full bg-slate-500"}," السابق ")])])]),default:l(()=>[t("div",kt,[t("label",wt,[xt,t("div",vt,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",Lt,b(e.form.qualification),1)]),items:l(()=>[(o(!0),n(g,null,y(e.qualifications,s=>(o(),_(f,{key:s.id,class:"hover:bg-blue-500",select:c=>{e.form.qualification=s.name,e.form.qualification_type=null}},{default:l(()=>[u(b(s.name),1)]),_:2},1032,["select"]))),128))]),_:1})]),e.form.errors.qualification!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.qualification},null,8,Mt)):a("",!0)]),t("label",Tt,[Ht,t("div",Ut,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",St,b(e.form.qualification_type),1)]),items:l(()=>{var s;return[(o(!0),n(g,null,y((s=e.qualifications.find(c=>c.name==e.form.qualification))==null?void 0:s.types,c=>(o(),_(f,{key:c.id,class:"hover:bg-blue-500",select:Ar=>e.form.qualification_type=c.name},{default:l(()=>[u(b(c.name),1)]),_:2},1032,["select"]))),128))]}),_:1})]),e.form.errors.type_of_identity!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.type_of_identity},null,8,Vt)):a("",!0)]),t("label",qt,[Dt,t("div",$t,[d(t("input",{dir:"rtl",type:"date","onUpdate:modelValue":r[11]||(r[11]=s=>e.form.qualification_from_date=s),max:e.form.qualification_to_date,class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,8,Ct),[[m,e.form.qualification_from_date]])]),e.form.errors.qualification_from_date!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.qualification_from_date},null,8,Bt)):a("",!0)]),t("label",jt,[Nt,t("div",Ft,[d(t("input",{dir:"rtl",type:"date",min:e.form.qualification_from_date,"onUpdate:modelValue":r[12]||(r[12]=s=>e.form.qualification_to_date=s),max:k.getToday(),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,8,Ot),[[m,e.form.qualification_to_date]])]),e.form.errors.qualification_to_date!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.qualification_to_date},null,8,Et)):a("",!0)])])]),_:1})):a("",!0),e.selectedSection==4?(o(),_(v,{key:3,label:"البيانات الوظيفيه"},{footer:l(()=>[t("div",Ds,[t("div",$s,[i(x,{type:"submit"},{default:l(()=>[u(" التالي ")]),_:1}),t("button",{onClick:r[19]||(r[19]=s=>e.selectedSection=3),type:"button",class:"w-full py-2 mx-2 text-sm font-semibold text-white rounded-full bg-slate-500"}," السابق ")])])]),default:l(()=>[t("div",It,[t("label",Kt,[zt,t("div",Jt,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",Pt,b(e.form.career_name),1)]),items:l(()=>[(o(!0),n(g,null,y(e.career_names,s=>(o(),_(f,{key:s.id,class:"hover:bg-blue-500",select:c=>e.form.career_name=s.name},{default:l(()=>[u(b(s.name),1)]),_:2},1032,["select"]))),128))]),_:1})]),e.form.errors.career_name!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.career_name},null,8,Qt)):a("",!0)]),t("label",Rt,[Wt,t("div",Xt,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",Yt,b(e.form.career_degree),1)]),items:l(()=>[(o(!0),n(g,null,y(e.career_degrees,s=>(o(),_(f,{key:s.id,class:"hover:bg-blue-500",select:c=>e.form.career_degree=s.name},{default:l(()=>[u(b(s.name),1)]),_:2},1032,["select"]))),128))]),_:1})]),e.form.errors.career_degree!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.career_degree},null,8,Zt)):a("",!0)]),t("div",es,[t("label",ts,[ss,t("div",rs,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",os,b(e.form.career_category),1)]),items:l(()=>[(o(!0),n(g,null,y(e.career_categories,s=>(o(),_(f,{key:s.id,class:"hover:bg-blue-500",select:c=>e.form.career_category=s.name},{default:l(()=>[u(b(s.name),1)]),_:2},1032,["select"]))),128))]),_:1})]),e.form.errors.career_category!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.career_category},null,8,ls)):a("",!0)]),t("label",ns,[as,t("div",is,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>[t("div",ds,b(e.form.career_type),1)]),items:l(()=>[i(f,{class:"hover:bg-blue-500",select:s=>e.form.career_type="ثابت"},{default:l(()=>[u(" ثابت ")]),_:1},8,["select"]),i(f,{class:"hover:bg-blue-500",select:s=>e.form.career_type="متعاقد"},{default:l(()=>[u(" متعاقد ")]),_:1},8,["select"])]),_:1})]),e.form.errors.career_type!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.career_type},null,8,ms)):a("",!0)])]),t("label",us,[bs,t("div",fs,[d(t("input",{dir:"rtl",type:"date","onUpdate:modelValue":r[14]||(r[14]=s=>e.form.date_of_hiring=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.date_of_hiring]])]),e.form.errors.date_of_hiring!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.date_of_hiring},null,8,cs)):a("",!0)]),t("label",_s,[ps,t("div",hs,[d(t("input",{dir:"rtl",type:"number","onUpdate:modelValue":r[15]||(r[15]=s=>e.form.work_permit=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.work_permit]])]),e.form.errors.work_permit!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.work_permit},null,8,gs)):a("",!0)]),t("label",ys,[ks,t("div",ws,[d(t("input",{dir:"rtl",type:"date","onUpdate:modelValue":r[16]||(r[16]=s=>e.form.permit_from=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.permit_from]])]),e.form.errors.permit_from!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.permit_from},null,8,xs)):a("",!0)]),t("label",vs,[Ls,t("div",Ms,[d(t("input",{dir:"rtl",type:"date",min:e.form.permit_from,"onUpdate:modelValue":r[17]||(r[17]=s=>e.form.permit_to=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,8,Ts),[[m,e.form.permit_to]])]),e.form.errors.permit_to!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.permit_to},null,8,Hs)):a("",!0)]),t("label",Us,[Ss,t("div",Vs,[d(t("input",{dir:"rtl",type:"number","onUpdate:modelValue":r[18]||(r[18]=s=>e.form.retirement_age=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.retirement_age]])]),e.form.errors.retirement_age!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.retirement_age},null,8,qs)):a("",!0)])])]),_:1})):a("",!0),e.selectedSection==5?(o(),_(v,{key:4,label:"بيانات الخدمة"},{footer:l(()=>[t("div",ar,[t("div",ir,[i(x,{type:"submit"},{default:l(()=>[u(" التالي ")]),_:1}),t("button",{onClick:r[25]||(r[25]=s=>e.selectedSection=4),type:"button",class:"w-full py-2 mx-2 text-sm font-semibold text-white rounded-full bg-slate-500"}," السابق ")])])]),default:l(()=>[t("div",Cs,[t("label",Bs,[js,t("div",Ns,[i(p,{classes:"bg-white border-2 border-gray-500"},{button:l(()=>{var s;return[t("div",Fs,b((s=e.groups.find(c=>c.id==e.form.group))==null?void 0:s.name),1)]}),items:l(()=>[(o(!0),n(g,null,y(e.groups,s=>(o(),_(f,{key:s.id,class:"hover:bg-blue-500",select:c=>e.form.group=s.id},{default:l(()=>[u(b(s.name),1)]),_:2},1032,["select"]))),128))]),_:1})]),e.form.errors.group!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.group},null,8,Os)):a("",!0)]),t("label",Es,[Gs,t("div",As,[d(t("input",{dir:"rtl",type:"date","onUpdate:modelValue":r[20]||(r[20]=s=>e.form.group_from=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.group_from]])]),e.form.errors.group_from!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.group_from},null,8,Is)):a("",!0)]),t("label",Ks,[zs,t("div",Js,[d(t("input",{dir:"rtl",type:"date",min:e.form.group_from,"onUpdate:modelValue":r[21]||(r[21]=s=>e.form.group_to=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,8,Ps),[[m,e.form.group_to]])]),e.form.errors.group_to!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.group_to},null,8,Qs)):a("",!0)]),t("label",Rs,[Ws,t("div",Xs,[d(t("input",{dir:"rtl",type:"date","onUpdate:modelValue":r[22]||(r[22]=s=>e.form.service_expirateion_date=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.service_expirateion_date]])]),e.form.errors.service_expirateion_date!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.service_expirateion_date},null,8,Ys)):a("",!0)]),t("label",Zs,[er,t("div",tr,[d(t("input",{dir:"rtl",type:"number","onUpdate:modelValue":r[23]||(r[23]=s=>e.form.in_work_date=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.in_work_date]])]),e.form.errors.in_work_date!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.in_work_date},null,8,sr)):a("",!0)]),t("label",rr,[or,t("div",lr,[d(t("input",{dir:"rtl",type:"number","onUpdate:modelValue":r[24]||(r[24]=s=>e.form.out_work_date=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.out_work_date]])]),e.form.errors.out_work_date!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.out_work_date},null,8,nr)):a("",!0)])])]),_:1})):a("",!0),e.selectedSection==6?(o(),_(v,{key:5,label:"بيانات الراتب"},{footer:l(()=>[t("div",jr,[t("div",Nr,[t("button",{onClick:r[32]||(r[32]=s=>e.selectedSection=4),type:"button",class:"w-full py-2 mx-2 text-sm font-semibold text-white rounded-full bg-slate-500"}," السابق ")])])]),default:l(()=>[t("div",dr,[t("label",mr,[ur,t("div",br,[d(t("input",{dir:"rtl",type:"number","onUpdate:modelValue":r[26]||(r[26]=s=>e.form.salary_primary=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.salary_primary]])]),e.form.errors.salary_primary!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.salary_primary},null,8,fr)):a("",!0)]),t("label",cr,[_r,t("div",pr,[d(t("input",{dir:"rtl",type:"number","onUpdate:modelValue":r[27]||(r[27]=s=>e.form.salary_all=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.salary_all]])]),e.form.errors.salary_all!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.salary_all},null,8,hr)):a("",!0)]),t("label",gr,[yr,t("div",kr,[d(t("input",{dir:"rtl",type:"date",max:e.form.salary_end,"onUpdate:modelValue":r[28]||(r[28]=s=>e.form.salary_start=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,8,wr),[[m,e.form.salary_start]])]),e.form.errors.salary_start!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.salary_start},null,8,xr)):a("",!0)]),t("label",vr,[Lr,t("div",Mr,[d(t("input",{dir:"rtl",type:"date",min:e.form.salary_start,"onUpdate:modelValue":r[29]||(r[29]=s=>e.form.salary_end=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,8,Tr),[[m,e.form.salary_end]])]),e.form.errors.salary_end!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.salary_end},null,8,Hr)):a("",!0)]),t("label",Ur,[Sr,t("div",Vr,[d(t("input",{dir:"rtl",type:"text","onUpdate:modelValue":r[30]||(r[30]=s=>e.form.salary_bank_name=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.salary_bank_name]])]),e.form.errors.salary_bank_name!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.salary_bank_name},null,8,qr)):a("",!0)]),t("label",Dr,[$r,t("div",Cr,[d(t("input",{dir:"rtl",type:"text","onUpdate:modelValue":r[31]||(r[31]=s=>e.form.salary_account_number=s),class:"pr-1 text-sm bg-transparent border-0 focus:ring-0"},null,512),[[m,e.form.salary_account_number]])]),e.form.errors.salary_account_number!=null?(o(),n("small",{key:0,class:"mt-1 mr-4 text-xs font-semibold text-red-800",innerHTML:e.form.errors.salary_account_number},null,8,Br)):a("",!0)])])]),_:1})):a("",!0),e.selectedSection>=6?(o(),n("div",Fr,[t("div",Or,[i(x,{onClick:r[33]||(r[33]=s=>e.form.done=!0),type:"submit"},{default:l(()=>[u(" حفظ ")]),_:1}),Er])])):a("",!0)],32)}const Qr=S(z,[["render",Gr]]);export{Qr as default};
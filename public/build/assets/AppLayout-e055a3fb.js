import{a as S,D as B}from"./DropdownList-9b3ede74.js";import{_,I as b}from"./_plugin-vue_export-helper-d97591f4.js";import{j as x,r as d,o as r,d as c,f,b as s,a as t,c as v,O as $,m as D,n as u,t as w,F as I,l as j,g,e as p,w as N,q as C}from"./app-65af30ef.js";const A={name:"NavLink",components:{Icon:b,Link:x},props:{icon:{type:String,required:!0},href:{type:String,required:!0},title:{type:String,required:!0}},computed:{isActive(){return this.$page.url===this.href}},methods:{navigate(e){e.preventDefault(),this.$inertia.visit(this.href)}}},H=["innerHTML"],M={key:1,class:"text-white w-40 truncate my-2 cursor-pointer flex border-r-2 border-white mx-auto"},O=["innerHTML"];function T(e,n,a,y,k,h){const i=d("Icon"),m=d("Link");return h.isActive?(r(),v("div",M,[s(i,{icon:a.icon,class:"px-4 w-14 h-6"},null,8,["icon"]),t("p",{innerHTML:a.title},null,8,O)])):(r(),c(m,{key:0,href:a.href,class:"flex w-40 border-r-2 hover:border-white border-primary hover:underline no-underline truncate hover:text-white text-gray-400 my-2 mx-auto items-center"},{default:f(()=>[s(i,{icon:a.icon,class:"px-4 w-14 h-6"},null,8,["icon"]),t("p",{innerHTML:a.title},null,8,H)]),_:1},8,["href"]))}const q=_(A,[["render",T]]),V={name:"AppLayout",components:{Icon:b,Link:x,NavLink:q,DropdownList:S,DropDownOption:B},data:()=>({currentItem:null,showSideBar:!1,branshes:[]}),async created(){var e;await this.getBranshes(),this.currentItem=(e=this.branshes.find(n=>n.id==window.sessionStorage.getItem("bransh")))==null?void 0:e.name},methods:{selectBransh(e){this.currentItem=this.branshes.find(n=>n.id==e).name,window.sessionStorage.setItem("bransh",e),this.$inertia.post("/bransh-session/"+e),window.location.reload()},async getBranshes(){await axios.get("/get_bransh").then(e=>{this.branshes=e.data})},logout(){$.post(this.route("logout"))}}},z={class:"w-full h-full overflow-hidden bg-gray-200"},F={class:"relative w-full h-full"},E={class:"flex items-center justify-start h-full col-span-2 px-2"},R=t("div",{class:"col-span-6 h-full flex items-center justify-center"},null,-1),G={class:"flex items-center h-full col-span-4 justify-evenly"},J={class:"h-8 w-52"},K={class:"cursor-pointer py-0.5 px-2 text-xs"},P={class:"relative row-span-1"},Q={class:"row-span-5 truncate"},U={class:"flex items-center w-40 mx-auto text-white truncate"},W={class:"flex flex-col items-stretch row-span-6 truncate"},X={class:"flex flex-col items-center justify-end row-span-3 pb-4 truncate"},Y={class:"flex items-center w-40 mx-auto my-2 text-white no-underline truncate hover:underline"};function Z(e,n,a,y,k,h){const i=d("Icon"),m=d("DropDownOption"),L=d("DropdownList"),o=d("NavLink");return r(),v("div",z,[t("main",{class:u(["fixed top-14 h-[87%] p-2 bg-transparent gap-2 left-0 transition-all duration-500 overflow-auto",e.showSideBar?"w-[85%]":"w-[95%]"])},[t("div",F,[D(e.$slots,"default")])],2),t("div",{class:u(["fixed top-0 left-0 grid h-12 grid-cols-12 gap-2 transition-all duration-500 bg-white shadow-md",e.showSideBar?"w-[85%]":"w-[95%]"])},[t("div",E,[s(i,{icon:"basil:notification-outline",class:"h-8"})]),R,t("div",G,[t("div",J,[e.$page.props.role=="admin"?(r(),c(L,{key:0,classes:"border-2"},{button:f(()=>[t("div",K,w(e.currentItem),1)]),items:f(()=>[(r(!0),v(I,null,j(e.branshes,l=>(r(),c(m,{key:l.id,class:"text-xs hover:bg-primary hover:text-white",select:ee=>h.selectBransh(l.id)},{default:f(()=>[g(w(l.name),1)]),_:2},1032,["select"]))),128))]),_:1})):p("",!0)]),t("div",{onClick:n[0]||(n[0]=(...l)=>h.logout&&h.logout(...l)),class:"flex items-center justify-center cursor-pointer h-max justify-self-end"},[s(i,{rotate:2,icon:"carbon:logout",class:"h-8"})])])],2),t("div",{class:u(["fixed right-0 grid h-full gap-2 transition-all duration-500 bg-primary rounded-l-md grid-rows-12",e.showSideBar?"w-44":"w-14"])},[t("div",P,[t("div",{onClick:n[1]||(n[1]=l=>e.showSideBar=!e.showSideBar),class:"absolute z-50 flex items-center justify-center w-6 h-6 rounded-full cursor-pointer top-10 bg-slate-600 -left-3"},[s(i,{icon:"ic:round-arrow-back-ios",rotate:e.showSideBar?2:0,class:"text-white"},null,8,["rotate"])])]),t("div",Q,[t("div",U,[t("p",{class:u(["px-4 w-full font-serif font-semibold transition-all duration-300",e.showSideBar?"text-4xl text-center":"text-xl"])},[g(" HR"),N(t("span",null,"MS",512),[[C,e.showSideBar]])],2)])]),t("div",W,[s(o,{icon:"carbon:home",href:"/",title:"الرئيسيه"}),s(o,{icon:"iconoir:stats-report",href:"/report",title:"تقرير الموظفين"}),e.$page.props.role=="admin"?(r(),c(o,{key:0,icon:"carbon:calendar-heat-map",href:"/shifts",title:"الدوام"})):p("",!0),s(o,{icon:"ph:fingerprint-thin",href:"/migration",title:"البصمات"}),s(o,{icon:"humbleicons:users",href:"/employees",title:"الموظفين"}),s(o,{icon:"icon-park-outline:vacation",href:"/vacations",title:"الاجازات"}),s(o,{icon:"fluent:tasks-app-20-regular",href:"/tasks",title:"التكاليف"}),e.$page.props.role=="admin"?(r(),c(o,{key:1,icon:"carbon:inventory-management",href:"/management",title:"الادارات"})):p("",!0),e.$page.props.role=="admin"?(r(),c(o,{key:2,icon:"ep:setting",href:"/setting",title:"الاعدادات"})):p("",!0)]),t("div",X,[t("div",Y,[s(i,{icon:"carbon:user",class:"h-6 px-4 w-14"}),g(" "+w(e.$page.props.auth.user.name.split(" ")[0])+" ",1)])])],2)])}const oe=_(V,[["render",Z]]);export{oe as A};

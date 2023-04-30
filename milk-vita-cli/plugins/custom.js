import Vue from 'vue';
import VueToastr from "vue-toastr";
import Calendar from 'vue-fullcalendar';
//
import PerfectScrollbar from 'vue2-perfect-scrollbar';
import { BFormDatepicker } from 'bootstrap-vue'
import Pagination from 'vue-pagination-2';
import Category from '@/components/system/Category';
import Location from '@/components/system/Location';
import Vselect from 'vue-select';
//
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css';
import 'vue-select/dist/vue-select.css';

Vselect.mixins.push({
    methods:{
        getPosition(el){
            var el2 = el;
            var curtop = 0;
            var curleft = 0;
            if (document.getElementById || document.all) {
                try {
                    while (el.offsetParent) {
                        curleft += el.offsetLeft-el.scrollLeft;
                        curtop += el.offsetTop-el.scrollTop;
                        el = el.offsetParent;
                        el2 = el2.parentNode;
                        while (el2 != el) {
                            curleft -= el2.scrollLeft;
                            curtop -= el2.scrollTop;
                            el2 = el2.parentNode;
                        }
                    };
                }
                catch(e){};

            } else if (document.layers) {
                curtop += el.y;
                curleft += el.x;
            }
            return {top:curtop, left:curleft};
        },
        setOption(){
            var min_rem = ((window.outerHeight/100)*50);
            var redio = this.getPosition(this.$el);

            

            if(min_rem < redio.top){
                
                this.$el.querySelector('[role=listbox]').classList.add('top');
            }
            else 
                this.$el.querySelector('[role=listbox]').classList.remove('top');
        }
    },
    watch:{
        open:function(){
            if(this.open){
                setTimeout(()=>{this.setOption()}, 200);
            }
        },
    },
    mounted() 
    {
        window.addEventListener("scroll", ()=>{
            this.setOption();
        });
    },
});

Vue.use(PerfectScrollbar);
Vue.use(VueToastr, {});
//
Vue.component('Calendar', Calendar);
Vue.component('Pagination', Pagination);
Vue.component('Category', Category);
Vue.component('date-picker', BFormDatepicker);
Vue.component('Location', Location);
Vue.component('select-picker', Vselect);




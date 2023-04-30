<template>
    <div class="card position-relative">
        <div class="card-header border-0">
            <img src="@/assets/icons/cows.webp" class="float-right demo-cows-" alt="" height="45px">
        </div>
        <!-- // -->
        <div class="card-body card-body-profile">
            <div class="profile-card">
                <div class="profile-pic">
                    <img :src="(user ? ($store.state.host_server+(user.photo_path ? user.photo_path :'images/user.jpg')):'')" alt="">
                </div>
                <div class="profile-info">
                    <h1>{{user.name_bn}}</h1>
                    <p>{{user.role_name ? user.role_name : '...'}}</p>
                    <p>{{user.entity_real_name ? user.entity_real_name : '...'}}</p>
                    <p v-if="user.chilling_plant_name && (user.role_slug=='association-manager')" style="color:rgb(85 169 91);margin:0">{{user.chilling_plant_name}}</p>
                </div>
            </div>
            <!-- // -->
            <div class="min70vh" style="position:relative" v-if="$store.state.menus.length>0">
                <Loader :loader="false"/>
                <InfoCards />
                <TaskSchedule v-if="$dashboardElement('/task-schedule/list')" />
            </div>
            <!-- 
                <AssociationManager v-if="user && (user.role_slug=='association-manager')" />
                <ChillingPlantManager v-if="user && (user.role_slug=='chilling-plant-manager')" />
                <ProcessingPlant v-if="user && (user.role_slug=='processing-plant-manager')" />
                <QCManager v-if="user && (user.role_slug=='qc-manager-processing-plant')" />
                <FieldOfficer v-if="user && (user.role_slug=='field-officer')" />
                <Distributor v-if="user && (user.role_slug=='distributor')" />
                <Delivery v-if="user && (user.role_slug=='delivery-man')" />
                <SuperAdmin v-if="user && (user.role_slug=='superadmin')" />
                <MilkVitaOfficer v-if="user && (user.role_slug=='chilling-plant-officer')" />
                <ZoneSupervisor v-if="user && (user.role_slug=='zone-supervisor')" />
                <VehicleManager v-if="user && (user.role_slug=='vehicle-manager-processing-plant')" />
                <Driver v-if="user && (user.role_slug=='driver-processing-plant')" />
            -->
            <!-- // -->
        </div>
    </div>
</template>

<script>

import AssociationManager from '@/components/dashboard/AssociationManager';
import ChillingPlantManager from '@/components/dashboard/ChillingPlantManager';
import FieldOfficer from '@/components/dashboard/FieldOfficer';
import ProcessingPlant from '@/components/dashboard/ProcessingPlant';
import Distributor from '@/components/dashboard/Distributor';
import Delivery from '@/components/dashboard/Delivery';
import QCManager from '@/components/dashboard/QCManager';
import SuperAdmin from '@/components/dashboard/SuperAdmin';
import MilkVitaOfficer from '@/components/dashboard/MilkVitaOfficer';
import ZoneSupervisor from '@/components/dashboard/ZoneSupervisor';
import VehicleManager from '@/components/dashboard/VehicleManager';
import Driver from '@/components/dashboard/Driver';

//
import InfoCards from '@/components/dashboard/InfoCards';
import TaskSchedule from '@/components/dashboard/modules/TaskSchedule';


export default {
    layout:'admin',
    components : {InfoCards, TaskSchedule, Driver, VehicleManager, ZoneSupervisor, AssociationManager, ChillingPlantManager, FieldOfficer, ProcessingPlant, Distributor, Delivery, QCManager, SuperAdmin, MilkVitaOfficer},
    head() {
        return {
            title : 'Dashboard | Milk Vita',
            meta  : [],
            script:[{hid: 'stripe', src: 'http://dashboard.rdcd.orangebd.com/components/doptor-employee-selector/component.js', defer: true}]
        }
    },
    data(){
        return {
            user:(this.$auth.user ? this.$auth.user : {})
        }
    },
};
</script>

<style src="@/assets/css/dashboard.css"></style>
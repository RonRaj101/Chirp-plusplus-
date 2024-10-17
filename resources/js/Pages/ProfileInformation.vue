<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Chirp from '@/Components/Chirp.vue';
import { ref, defineProps } from 'vue';
import { usePage } from '@inertiajs/vue3';
//need to use $page for initial prop movement, second prop movement is done by defineProps

const props = defineProps(['user', 'chirps']);

</script>

<template>
    <Head title="Profile Information"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
        </template>

        <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                
                </div>
            </div>
        </div> -->
       
            <div class="mt-6 max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white shadow-sm rounded-lg divide-y">
                
                <div class="p-6">
                    <div class="text-xl font-semibold text-gray-800">{{ user.name }}</div>
                    <div class="text-gray-500">{{ user.email }}</div>
                </div>

               

                <div class="mt-6 p-1 bg-white shadow-sm rounded-lg divide-y">
                    <Chirp
                        v-for="chirp in chirps"
                        :key="chirp.id"
                        :chirp="chirp"
                    />
                    
                    <div v-if="chirps.length === 0"  class="p-6 text-center text-gray-500">No Chirps to show for!!</div>
                </div>
                
            </div>
        
        
    </AuthenticatedLayout>
</template>

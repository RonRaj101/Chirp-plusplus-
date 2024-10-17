<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Chirp from '@/Components/Chirp.vue';

import timeSinceLastChirp from '@/Helpers/timeSinceLastChirp.js';

defineProps(['chirps']);




</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <p>
            <span class="font-semibold text-xl text-gray-800 leading-tight">{{ $page.component }}</span>
            <span class="text-xl text-black float-end"> {{ new Date().toDateString() }} </span>
            </p>
        </template>

        
       
            <div class="mt-6 max-w-2xl text- mx-auto sm:px-6 lg:px-8 bg-white shadow-sm rounded-lg divide-y">
                <Chirp
                    v-for="chirp in chirps"
                    :key="chirp.id"
                    :chirp="chirp"
                />
                
                <div v-if="chirps.length === 0"  class="p-6 text-center text-gray-500">No chirps yet. <u><a :href="route('chirps.index')">Make your first chirp!</a></u></div>
            </div>
            

            
    </AuthenticatedLayout>
</template>

<style> 

</style>

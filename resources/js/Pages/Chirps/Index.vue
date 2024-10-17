<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue'
import { useForm, Head } from '@inertiajs/vue3';
import Chirp from '../../Components/Chirp.vue';
import timeSinceLastChirp from '@/Helpers/timeSinceLastChirp.js';
import { defineProps } from 'vue';

const props = defineProps(['chirps']);
 
const form = useForm({
    message: '',
    privacy_status: 'priv'
});
//this leads to the value not being reactive, hence we dont use this. Instead we use the actual method in the html
//const daysSinceLastChirp = ref(timeSinceLastChirp(props.chirps[0].created_at));

</script>
 
<template>
    <Head title="Chirps" />
 
    <AuthenticatedLayout>

        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <!-- timeSinceLastChirp(chirps[0].created_at) < 1 ? 'blur-sm' : 'blur-none' -->
            <form @submit.prevent="form.post(route('chirps.store'), { onSuccess: () => form.reset() })" >
                <div v-if="timeSinceLastChirp(chirps[0].created_at) < 1" class="absolute inset-2 z-10 flex justify-items-center justify-center self-center">
                    <div class="bg-white p-4 rounded-lg shadow-lg">
                        <h1 class="text-xl font-bold text-center">You can only post once a day</h1>
                        <p class="text-center">You can post again in <span class="font-semibold">{{Math.ceil(24 - timeSinceLastChirp(chirps[0].created_at))}} hours</span> </p>
                    </div>
                </div>
                <fieldset class="disabled:blur-sm" :disabled="timeSinceLastChirp(chirps[0].created_at) < 1">
        
                <textarea
                    v-model="form.message"
                    rows="10"
                    minlength="100"
                    placeholder="What's on your mind today?"
                    class="block whitespace-pre w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    required
                ></textarea>
                <InputLabel class="text-end" :class="form.message.length < 100 ? 'text-red-400' : 'text-green-500'">{{form.message.length}}/100</InputLabel>
                <InputLabel class="text-start mb-1">Post Visibility</InputLabel>
                <select name="visibility" v-model="form.privacy_status" class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="priv" selected>Private</option>
                    <option value="publ">Public</option>
                </select>
                
                <!-- <InputError :message="form.errors.message" class="mt-2" /> -->

                <PrimaryButton class="mt-4" :disabled="form.message.length < 100">Post</PrimaryButton>
            </fieldset>
            </form>
            
            <div class="mt-6 p-1 bg-white shadow-sm rounded-lg divide-y">
                <Chirp
                    v-for="chirp in chirps"
                    :key="chirp.id"
                    :chirp="chirp"
                />
                
                <div v-if="chirps.length === 0"  class="p-6 text-center text-gray-500">It's Empty here, make your first chirp!</div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

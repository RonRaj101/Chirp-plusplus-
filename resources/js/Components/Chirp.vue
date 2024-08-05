<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue'


const props = defineProps(['chirp']);
 
const form = useForm({
    message: props.chirp.message,
    privacy_status: props.chirp.privacy_status
});
 
const editing = ref(false);
</script>
 
<template>
    <div class="p-6 flex space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <span v-if="chirp.user.name !== null" class="text-gray-800"><a :href="route('profile.show', chirp.user.id)">
                        <span v-if="chirp.user.id === $page.props.auth.user.id">Me</span>
                        <span v-else>{{ chirp.user.name }}</span>
                    </a></span>
                    <small class="ml-2 text-sm text-gray-600">{{ new Date(chirp.created_at).toLocaleDateString() }}</small>
                    <small v-if="chirp.created_at !== chirp.updated_at" class="text-sm text-gray-600"> &middot; edited</small>
                    
                    <svg v-if="chirp.privacy_status=='priv'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sm -scale-x-100 inline-flex ml-2"  viewBox="0 0 448 512">
                        <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/>                    
                    </svg>
                
                </div>

                <Dropdown v-if="chirp.user.id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Edit
                        </button>
                        <DropdownLink as="button" :href="route('chirps.destroy', chirp.id)" method="delete">
                            Delete
                        </DropdownLink>
                    </template>
                    
                </Dropdown>
            </div>
            <form v-if="editing" @submit.prevent="form.put(route('chirps.update', chirp.id), { onSuccess: () => editing = false })">
                <textarea v-model="form.message" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" minlength="100" rows="10" required></textarea>
                <InputLabel class="text-end" :class=" form.message.length < 100 ? 'text-red-400' : 'text-green-500'">{{form.message.length}}/100 </InputLabel>
                <InputLabel class="text-start mb-1">Post Visibility</InputLabel>
                <select name="visibility" v-model="form.privacy_status" class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="">
                    <option value="priv" selected>Private</option>
                    <option value="publ">Public</option>
                </select>

                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <span v-else class="mt-4 mx-1 overflow-ellipsis text-gray-900">
               {{ chirp.message }}
            </span>
        </div>
    </div>
</template>
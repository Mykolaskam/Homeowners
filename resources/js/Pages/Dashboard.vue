<script setup>
import {ref} from 'vue'
import DefaultLayout from '@/Layouts/Default.vue';
import Modal from '@/Components/Modal.vue';
import {Head} from '@inertiajs/inertia-vue3';
import {useForm} from '@inertiajs/inertia-vue3'

const props = defineProps({
    homeowners: {
        default: [],
        type: Array
    }
})

let showModal = ref(false)
const form = useForm({
    file: null,
})

const handleFile = (e) => {
    form.file = e.target.files[0]
    showModal.value = true

    form.post('/', {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = false
            form.reset()
        },
    })
}
</script>

<template>
    <Modal :open="showModal"/>
    <Head title="Dashboard"/>

    <DefaultLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="px-4 sm:px-6 lg:px-8">
                            <div class="sm:flex sm:items-center">
                                <div class="sm:flex-auto">
                                    <h1 class="text-xl font-semibold text-gray-900">Homeowners</h1>
                                    <p class="mt-2 text-sm text-gray-700">Just a list of homeowners, feel free to import some ¯\_(ツ)_/¯</p>
                                </div>
                                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                    <label for="upload-file"
                                           class="cursor-pointer inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                                        Import CSV
                                        <input type="file" id="upload-file" accept=".csv" hidden @input="handleFile($event)"/>
                                    </label>
                                </div>
                            </div>
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                            <table v-if="homeowners.length" class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold uppercase text-gray-900">
                                                        Title
                                                    </th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold uppercase text-gray-900">
                                                        Initial
                                                    </th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold uppercase text-gray-900">
                                                        First Name
                                                    </th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold uppercase text-gray-900">
                                                        Last Name
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 bg-white">
                                                <tr v-for="(homeowner, homeowner_index) in homeowners" :key="homeowner.email"
                                                    :class="homeowner_index % 2 === 0 ? undefined : 'bg-gray-50'">
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ homeowner.title ?? '-' }}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ homeowner.initial ?? '-' }}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{
                                                            homeowner.first_name ?? '-'
                                                        }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{
                                                            homeowner.last_name ?? '-'
                                                        }}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <template v-else>
                                                <div class="text-center py-12">
                                                    <h3 class="mt-2 text-md font-semibold text-gray-900">No homeowners to show</h3>
                                                    <p class="mt-1 text-sm text-gray-500">Get started by importing a CSV file.</p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

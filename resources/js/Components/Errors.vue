<script setup>
import {XCircleIcon} from '@heroicons/vue/solid'
</script>

<template>
    <div class="rounded-md bg-red-50 p-4" v-if="Object.keys($page.props.errors).length">
        <div class="flex">
            <div class="flex-shrink-0">
                <XCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true"/>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Sorry, there was a problem with your request</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul role="list" class="list-disc pl-5 space-y-1">
                        <li v-for="error in $page.props.errors">{{ error }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

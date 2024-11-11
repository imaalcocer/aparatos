<template>
    <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg v-if="icon === 'user'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 12c2.67 0 8 1.34 8 4v1H4v-1c0-2.66 5.33-4 8-4zm0-6a3 3 0 110 6 3 3 0 010-6z"></path>
            </svg>
            <svg v-if="icon === 'location'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 10a2 2 0 110-4 2 2 0 010 4z"></path>
            </svg>
            <svg v-if="icon === 'calendar'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 8h18M8 4v4m8-4v4M3 20h18a2 2 0 002-2V8a2 2 0 00-2-2H3a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </span>
        <input
            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
            placeholder="text"
            :type="type"
            :required="required"
            :accept="accept"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
        />
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue', 'text', 'type', 'required', 'accept', 'icon']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>

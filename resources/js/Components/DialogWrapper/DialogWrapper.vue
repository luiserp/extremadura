<template>
    <template v-for="dialogRef in dialogRefStore">
        <component :is="dialogRef.dialog" :show="dialogRef.show" v-bind="dialogRef.props" @confirm="dialogRef.confirm"
            @close="dialogRef.cancel">
        </component>
    </template>
</template>

<script setup>
import { dialogRefStore } from '@/Composables/Dialogs/useDialogs.js';
</script>

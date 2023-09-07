<script setup>
import MainCard from './MainCard.vue';
</script>
<template>
    <MainCard>
        <slot name="left_side">
            <div class="w-full flex items-center justify-between p-4">
                <slot name="header" />
            </div>
            <div class="w-full pb-4 px-2">
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <slot name="table_header" />
                        </tr>
                    </thead>
                    <tbody>
                        <slot name="table_body"></slot>
                    </tbody>
                </table>
            </div>
        </slot>
    </MainCard>
</template>

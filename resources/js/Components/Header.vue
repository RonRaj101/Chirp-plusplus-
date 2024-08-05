<script setup>



</script>

<template>
    <p>
        <span class="font-semibold text-xl text-gray-800 leading-tight">{{ $page.component }}</span>
        <span class="text-xl text-black float-end"> {{ new Date().toDateString() }} </span>
    </p>
</template>
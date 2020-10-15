<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Estate
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <estate-manager :estates="estates" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import EstateManager from './EstateManager'
import AppLayout from './../../Layouts/AppLayout'
import JetSectionBorder from './../../Jetstream/SectionBorder'

export default {
    props: [
        'estates'
    ],

    components: {
        EstateManager,
        AppLayout,
        JetSectionBorder,
    },
}
</script>

<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Owner
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <owner-manager :owners="owners" :unowned="unowned" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import OwnerManager from './OwnerManager'
import AppLayout from './../../Layouts/AppLayout'
import JetSectionBorder from './../../Jetstream/SectionBorder'

export default {
    props: [
        'owners',
        'unowned',
    ],

    components: {
        OwnerManager,
        AppLayout,
        JetSectionBorder,
    },
}
</script>

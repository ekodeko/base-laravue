<script setup>
import { router } from '@inertiajs/vue3'
import {
  Pagination,
  PaginationContent,
  PaginationItem,
  PaginationNext,
  PaginationPrevious,
} from '@/components/ui/pagination'

const props = defineProps({
  meta: { type: Object, required: true },
  links: { type: Object, required: true },
})

const goToPage = (url) => {
  if (url) {
    router.visit(url, { preserveState: true, preserveScroll: true })
  }
}
</script>

<template>
  <Pagination
    :total="meta.total"
    :items-per-page="meta.per_page"
    :default-page="meta.current_page"
    v-slot="{ page }"
  >
    <PaginationContent>
      <!-- Prev -->
      <PaginationPrevious
        v-if="links.prev"
        as-child
        @click.prevent="goToPage(links.prev)"
      >
        <button class="px-3 py-1 rounded border">Prev</button>
      </PaginationPrevious>

      <!-- Numbered pages -->
      <PaginationItem
        v-for="p in meta.last_page"
        :key="p"
        :value="p"
        :is-active="p === page"
        as-child
      >
        <button
          class="px-3 py-1 rounded border"
          :class="{ 'bg-gray-200 font-semibold': p === page }"
          @click.prevent="goToPage(`${meta.path}?page=${p}`)"
        >
          {{ p }}
        </button>
      </PaginationItem>

      <!-- Next -->
      <PaginationNext
        v-if="links.next"
        as-child
        @click.prevent="goToPage(links.next)"
      >
        <button class="px-3 py-1 rounded border">Next</button>
      </PaginationNext>
    </PaginationContent>
  </Pagination>
</template>

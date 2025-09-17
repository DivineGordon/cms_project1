<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Pages</h1>
          <p class="text-gray-600">Manage your website pages</p>
        </div>
        <Button @click="$inertia.visit(route('pages.create'))">
          <Icon name="plus" class="w-4 h-4 mr-2" />
          New Page
        </Button>
      </div>

      <!-- Filters -->
      <Card>
        <CardContent class="p-6">
          <div class="flex items-center space-x-4">
            <div class="flex-1">
              <Input
                v-model="search"
                placeholder="Search pages..."
                class="max-w-sm"
              />
            </div>
            <Select v-model="statusFilter">
              <SelectTrigger class="w-40">
                <SelectValue placeholder="All Status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="">All Status</SelectItem>
                <SelectItem value="published">Published</SelectItem>
                <SelectItem value="draft">Draft</SelectItem>
              </SelectContent>
            </Select>
          </div>
        </CardContent>
      </Card>

      <!-- Pages Table -->
      <Card>
        <CardContent class="p-0">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="border-b">
                <tr>
                  <th class="text-left p-4 font-medium text-gray-900">Title</th>
                  <th class="text-left p-4 font-medium text-gray-900">Slug</th>
                  <th class="text-left p-4 font-medium text-gray-900">Theme</th>
                  <th class="text-left p-4 font-medium text-gray-900">Status</th>
                  <th class="text-left p-4 font-medium text-gray-900">Views</th>
                  <th class="text-left p-4 font-medium text-gray-900">Updated</th>
                  <th class="text-right p-4 font-medium text-gray-900">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="page in filteredPages" :key="page.id" class="border-b hover:bg-gray-50">
                  <td class="p-4">
                    <div class="flex items-center space-x-3">
                      <div class="p-2 bg-gray-100 rounded-lg">
                        <Icon name="file-text" class="w-4 h-4 text-gray-600" />
                      </div>
                      <div>
                        <h3 class="font-medium text-gray-900">{{ page.title }}</h3>
                        <p class="text-sm text-gray-600">{{ page.meta_title || 'No meta title' }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="p-4">
                    <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ page.slug }}</code>
                  </td>
                  <td class="p-4">
                    <Badge variant="outline">{{ page.theme.name }}</Badge>
                  </td>
                  <td class="p-4">
                    <Badge :variant="page.is_published ? 'default' : 'secondary'">
                      {{ page.is_published ? 'Published' : 'Draft' }}
                    </Badge>
                  </td>
                  <td class="p-4">
                    <span class="text-sm text-gray-600">{{ page.analytics_count || 0 }}</span>
                  </td>
                  <td class="p-4">
                    <span class="text-sm text-gray-600">{{ formatDate(page.updated_at) }}</span>
                  </td>
                  <td class="p-4">
                    <div class="flex items-center justify-end space-x-2">
                      <Button
                        variant="outline"
                        size="sm"
                        @click="togglePublish(page)"
                      >
                        {{ page.is_published ? 'Unpublish' : 'Publish' }}
                      </Button>
                      <Button
                        variant="outline"
                        size="sm"
                        @click="$inertia.visit(route('pages.edit', page.id))"
                      >
                        Edit
                      </Button>
                      <Button
                        variant="outline"
                        size="sm"
                        @click="deletePage(page)"
                      >
                        Delete
                      </Button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </CardContent>
      </Card>

      <!-- Pagination -->
      <div v-if="pages.links" class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
          Showing {{ pages.from }} to {{ pages.to }} of {{ pages.total }} results
        </div>
        <div class="flex space-x-2">
          <Button
            v-for="link in pages.links"
            :key="link.label"
            variant="outline"
            size="sm"
            :disabled="!link.url"
            @click="link.url && $inertia.visit(link.url)"
            v-html="link.label"
          />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Input } from '@/components/ui/input'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import Icon from '@/components/Icon.vue'

const props = defineProps<{
  pages: {
    data: Array<{
      id: number
      title: string
      slug: string
      meta_title: string | null
      is_published: boolean
      updated_at: string
      theme: {
        name: string
      }
      analytics_count: number
    }>
    links: Array<{
      label: string
      url: string | null
    }>
    from: number
    to: number
    total: number
  }
}>()

const search = ref('')
const statusFilter = ref('')

const filteredPages = computed(() => {
  let filtered = props.pages.data

  if (search.value) {
    filtered = filtered.filter(page =>
      page.title.toLowerCase().includes(search.value.toLowerCase()) ||
      page.slug.toLowerCase().includes(search.value.toLowerCase())
    )
  }

  if (statusFilter.value) {
    filtered = filtered.filter(page => {
      if (statusFilter.value === 'published') return page.is_published
      if (statusFilter.value === 'draft') return !page.is_published
      return true
    })
  }

  return filtered
})

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString()
}

const togglePublish = (page: any) => {
  // Implementation for toggle publish
  console.log('Toggle publish for page:', page.id)
}

const deletePage = (page: any) => {
  if (confirm('Are you sure you want to delete this page?')) {
    // Implementation for delete page
    console.log('Delete page:', page.id)
  }
}
</script>

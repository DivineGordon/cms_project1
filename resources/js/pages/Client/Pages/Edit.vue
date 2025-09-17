<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Edit Page</h1>
          <p class="text-gray-600">{{ page.title }}</p>
        </div>
        <div class="flex space-x-3">
          <Button variant="outline" @click="$inertia.visit(route('pages.index'))">
            Back to Pages
          </Button>
          <Button @click="savePage">
            <Icon name="save" class="w-4 h-4 mr-2" />
            Save Changes
          </Button>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Page Editor -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Basic Information -->
          <Card>
            <CardHeader>
              <CardTitle>Page Information</CardTitle>
            </CardHeader>
            <CardContent class="space-y-4">
              <div>
                <Label for="title">Title</Label>
                <Input
                  id="title"
                  v-model="form.title"
                  placeholder="Enter page title"
                />
              </div>
              <div>
                <Label for="slug">Slug</Label>
                <Input
                  id="slug"
                  v-model="form.slug"
                  placeholder="page-slug"
                />
              </div>
              <div>
                <Label for="theme">Theme</Label>
                <Select v-model="form.theme_id">
                  <SelectTrigger>
                    <SelectValue placeholder="Select a theme" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem
                      v-for="theme in themes"
                      :key="theme.id"
                      :value="theme.id"
                    >
                      {{ theme.name }}
                    </SelectItem>
                  </SelectContent>
                </Select>
              </div>
            </CardContent>
          </Card>

          <!-- Content Editor -->
          <Card>
            <CardHeader>
              <CardTitle>Page Content</CardTitle>
            </CardHeader>
            <CardContent>
              <div class="space-y-4">
                <div v-for="(section, index) in form.content.sections" :key="index" class="border rounded-lg p-4">
                  <div class="flex items-center justify-between mb-3">
                    <h3 class="font-medium">{{ section.type }}</h3>
                    <Button
                      variant="outline"
                      size="sm"
                      @click="removeSection(index)"
                    >
                      <Icon name="trash-2" class="w-4 h-4" />
                    </Button>
                  </div>
                  
                  <div v-if="section.type === 'hero'" class="space-y-3">
                    <div>
                      <Label>Headline</Label>
                      <Input
                        v-model="section.data.headline"
                        placeholder="Enter headline"
                      />
                    </div>
                    <div>
                      <Label>Subheadline</Label>
                      <Input
                        v-model="section.data.subheadline"
                        placeholder="Enter subheadline"
                      />
                    </div>
                    <div>
                      <Label>Button Text</Label>
                      <Input
                        v-model="section.data.buttonText"
                        placeholder="Enter button text"
                      />
                    </div>
                  </div>

                  <div v-else-if="section.type === 'text'" class="space-y-3">
                    <div>
                      <Label>Content</Label>
                      <textarea
                        v-model="section.data.content"
                        class="w-full p-3 border rounded-lg"
                        rows="4"
                        placeholder="Enter text content"
                      />
                    </div>
                  </div>

                  <div v-else-if="section.type === 'features'" class="space-y-3">
                    <div v-for="(feature, featureIndex) in section.data.features" :key="featureIndex" class="flex space-x-2">
                      <Input
                        v-model="feature.title"
                        placeholder="Feature title"
                      />
                      <Input
                        v-model="feature.description"
                        placeholder="Feature description"
                      />
                      <Button
                        variant="outline"
                        size="sm"
                        @click="removeFeature(index, featureIndex)"
                      >
                        <Icon name="trash-2" class="w-4 h-4" />
                      </Button>
                    </div>
                    <Button
                      variant="outline"
                      size="sm"
                      @click="addFeature(index)"
                    >
                      <Icon name="plus" class="w-4 h-4 mr-2" />
                      Add Feature
                    </Button>
                  </div>
                </div>

                <Button
                  variant="outline"
                  @click="addSection"
                  class="w-full"
                >
                  <Icon name="plus" class="w-4 h-4 mr-2" />
                  Add Section
                </Button>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
          <!-- Publish Settings -->
          <Card>
            <CardHeader>
              <CardTitle>Publish Settings</CardTitle>
            </CardHeader>
            <CardContent class="space-y-4">
              <div class="flex items-center space-x-2">
                <Checkbox
                  id="is_published"
                  v-model:checked="form.is_published"
                />
                <Label for="is_published">Published</Label>
              </div>
              <Button
                v-if="!form.is_published"
                @click="form.is_published = true"
                class="w-full"
              >
                Publish Page
              </Button>
            </CardContent>
          </Card>

          <!-- SEO Settings -->
          <Card>
            <CardHeader>
              <CardTitle>SEO Settings</CardTitle>
            </CardHeader>
            <CardContent class="space-y-4">
              <div>
                <Label for="meta_title">Meta Title</Label>
                <Input
                  id="meta_title"
                  v-model="form.meta_title"
                  placeholder="Enter meta title"
                />
              </div>
              <div>
                <Label for="meta_description">Meta Description</Label>
                <textarea
                  id="meta_description"
                  v-model="form.meta_description"
                  class="w-full p-3 border rounded-lg"
                  rows="3"
                  placeholder="Enter meta description"
                />
              </div>
            </CardContent>
          </Card>

          <!-- Preview -->
          <Card>
            <CardHeader>
              <CardTitle>Preview</CardTitle>
            </CardHeader>
            <CardContent>
              <Button
                variant="outline"
                class="w-full"
                @click="previewPage"
              >
                <Icon name="eye" class="w-4 h-4 mr-2" />
                Preview Page
              </Button>
            </CardContent>
          </Card>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Checkbox } from '@/components/ui/checkbox'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import Icon from '@/components/Icon.vue'

const props = defineProps<{
  page: {
    id: number
    title: string
    slug: string
    content: any
    meta_title: string | null
    meta_description: string | null
    is_published: boolean
    theme: {
      id: number
      name: string
    }
  }
  themes: Array<{
    id: number
    name: string
  }>
}>()

const form = reactive({
  title: props.page.title,
  slug: props.page.slug,
  theme_id: props.page.theme.id,
  content: props.page.content || { sections: [] },
  meta_title: props.page.meta_title || '',
  meta_description: props.page.meta_description || '',
  is_published: props.page.is_published,
})

const addSection = () => {
  form.content.sections.push({
    type: 'text',
    data: {
      content: ''
    }
  })
}

const removeSection = (index: number) => {
  form.content.sections.splice(index, 1)
}

const addFeature = (sectionIndex: number) => {
  form.content.sections[sectionIndex].data.features.push({
    title: '',
    description: ''
  })
}

const removeFeature = (sectionIndex: number, featureIndex: number) => {
  form.content.sections[sectionIndex].data.features.splice(featureIndex, 1)
}

const savePage = () => {
  // Implementation for saving page
  console.log('Saving page:', form)
}

const previewPage = () => {
  // Implementation for preview
  console.log('Previewing page')
}
</script>

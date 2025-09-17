<template>
  <div class="min-h-screen" :style="pageStyles">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <h1 class="text-xl font-bold" :style="{ color: themeColors.primary }">
                {{ client.company_name || client.name }}
              </h1>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <a
              v-for="link in navigationLinks"
              :key="link.href"
              :href="link.href"
              class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium"
              :style="{ color: themeColors.text }"
            >
              {{ link.text }}
            </a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <main>
      <!-- Hero Section -->
      <section v-if="heroSection" class="py-20" :style="{ backgroundColor: themeColors.background }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h1 class="text-4xl font-bold mb-4" :style="{ color: themeColors.primary }">
            {{ heroSection.data.headline }}
          </h1>
          <p class="text-xl mb-8" :style="{ color: themeColors.text }">
            {{ heroSection.data.subheadline }}
          </p>
          <button
            v-if="heroSection.data.buttonText"
            class="px-6 py-3 rounded-lg font-medium"
            :style="{
              backgroundColor: themeColors.primary,
              color: themeColors.accent
            }"
          >
            {{ heroSection.data.buttonText }}
          </button>
        </div>
      </section>

      <!-- Text Section -->
      <section v-if="textSection" class="py-16" :style="{ backgroundColor: themeColors.background }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="prose prose-lg max-w-none" :style="{ color: themeColors.text }">
            <p v-html="textSection.data.content"></p>
          </div>
        </div>
      </section>

      <!-- Features Section -->
      <section v-if="featuresSection" class="py-16" :style="{ backgroundColor: themeColors.accent }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
              v-for="(feature, index) in featuresSection.data.features"
              :key="index"
              class="text-center"
            >
              <h3 class="text-xl font-semibold mb-2" :style="{ color: themeColors.primary }">
                {{ feature.title }}
              </h3>
              <p :style="{ color: themeColors.text }">
                {{ feature.description }}
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Custom Sections -->
      <section
        v-for="(section, index) in customSections"
        :key="index"
        class="py-16"
        :style="{ backgroundColor: themeColors.background }"
      >
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <div :style="{ color: themeColors.text }">
            <h2 v-if="section.data.title" class="text-2xl font-bold mb-4" :style="{ color: themeColors.primary }">
              {{ section.data.title }}
            </h2>
            <div v-if="section.data.content" v-html="section.data.content"></div>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="py-8" :style="{ backgroundColor: themeColors.primary, color: themeColors.accent }">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p>&copy; {{ new Date().getFullYear() }} {{ client.company_name || client.name }}. All rights reserved.</p>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps<{
  page: {
    title: string
    content: {
      sections: Array<{
        type: string
        data: any
      }>
    }
    theme: {
      colors: {
        primary: string
        secondary: string
        accent: string
        background: string
        text: string
      }
    }
  }
  client: {
    name: string
    company_name: string | null
  }
}>()

const themeColors = computed(() => props.page.theme.colors)

const pageStyles = computed(() => ({
  backgroundColor: themeColors.value.background,
  color: themeColors.value.text,
}))

const heroSection = computed(() => 
  props.page.content.sections.find(section => section.type === 'hero')
)

const textSection = computed(() => 
  props.page.content.sections.find(section => section.type === 'text')
)

const featuresSection = computed(() => 
  props.page.content.sections.find(section => section.type === 'features')
)

const customSections = computed(() => 
  props.page.content.sections.filter(section => 
    !['hero', 'text', 'features'].includes(section.type)
  )
)

const navigationLinks = computed(() => [
  { text: 'Home', href: '#' },
  { text: 'About', href: '#about' },
  { text: 'Contact', href: '#contact' },
])
</script>

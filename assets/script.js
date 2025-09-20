document.addEventListener("DOMContentLoaded", function () {
  const generatorContainer = document.getElementById("ai-builder-container");
  if (!generatorContainer) return;

  let formData = {
    features: [],
  };

  // --- FORM INTERACTIONS ---

  function initializeForm() {
    // Website type selection
    generatorContainer.querySelectorAll(".website-type").forEach((button) => {
      button.addEventListener("click", function () {
        generatorContainer
          .querySelectorAll(".website-type")
          .forEach((btn) => btn.classList.remove("selected"));
        this.classList.add("selected");
        formData.websiteType = this.getAttribute("data-value");
      });
    });

    // Design style selection
    generatorContainer.querySelectorAll(".design-style").forEach((button) => {
      button.addEventListener("click", function () {
        generatorContainer
          .querySelectorAll(".design-style")
          .forEach((btn) => btn.classList.remove("selected"));
        this.classList.add("selected");
        formData.designStyle = this.getAttribute("data-value");
      });
    });

    // Feature selection
    generatorContainer.querySelectorAll(".feature").forEach((button) => {
      button.addEventListener("click", function () {
        const value = this.getAttribute("data-value");
        if (formData.features.includes(value)) {
          formData.features = formData.features.filter((f) => f !== value);
          this.classList.remove("selected");
        } else {
          formData.features.push(value);
          this.classList.add("selected");
        }
      });
    });

    // Text and Select inputs
    const inputs = [
      "businessType",
      "targetAudience",
      "businessDescription",
      "existingWebsite",
      "competitors",
      "designInspiration",
      "additionalRequirements",
      "industry",
      "companySize",
      "businessGoal",
      "budget",
      "pageCount",
      "contentStatus",
      "timeline",
      "currentWebsite",
      "existingBranding",
      "colorPreference",
    ];

    inputs.forEach((id) => {
      const element = document.getElementById(id);
      if (element) {
        const eventType =
          element.tagName.toLowerCase() === "select" ? "change" : "input";
        element.addEventListener(eventType, function () {
          formData[id] = this.value;
          if (id === "businessType" || id === "industry") validateForm();
        });
      }
    });

    // Generate button
    document
      .getElementById("generateBtn")
      .addEventListener("click", function () {
        if (validateForm()) {
          generateConcept();
        }
      });

    // Reset button
    const resetButton = document.getElementById("resetBtn");
    if (resetButton) {
      resetButton.addEventListener("click", resetGenerator);
    }

    validateForm();
  }

  function validateForm() {
    const businessType = document.getElementById("businessType")?.value;
    const industry = document.getElementById("industry")?.value;
    const isValid = businessType && industry;

    const validationMessage = document.getElementById("validation-message");
    const generateBtn = document.getElementById("generateBtn");

    if (isValid) {
      validationMessage.classList.add("hidden");
      generateBtn.disabled = false;
      generateBtn.classList.remove("opacity-50", "cursor-not-allowed");
      return true;
    } else {
      validationMessage.classList.remove("hidden");
      generateBtn.disabled = true;
      generateBtn.classList.add("opacity-50", "cursor-not-allowed");
      return false;
    }
  }

  // --- API CALL AND LOADING STATE ---

  async function generateConcept() {
    document.getElementById("form-section").classList.add("hidden");
    document.getElementById("loading-section").classList.remove("hidden");

    // Animate progress steps
    const steps = document.querySelectorAll("#loading-section .progress-step");
    for (let i = 0; i < steps.length; i++) {
      await new Promise((resolve) => setTimeout(resolve, 600));
      steps[i].classList.add("active");
      const iconContainer = steps[i].querySelector(".flex.items-center > div");
      iconContainer.innerHTML = `
                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>`;
    }

    try {
      const response = await fetch(aiBuilderAjax.ajaxUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          action: "generate_concept",
          nonce: aiBuilderAjax.nonce,
          formData: JSON.stringify(formData),
        }),
      });

      const result = await response.json();

      if (result.success) {
        renderResults(result.data);
      } else {
        renderError(result.data.message || "An unknown error occurred.");
      }
    } catch (error) {
      console.error("Error calling AI:", error);
      renderError(
        "Failed to fetch the concept. Please check the console for more details."
      );
    }
  }

  // --- RENDERING RESULTS AND ERRORS ---

  function renderResults(data) {
    document.getElementById("loading-section").classList.add("hidden");
    const resultsSection = document.getElementById("results-section");
    resultsSection.classList.remove("hidden");

    // Populate header
    document.getElementById("conceptBusinessName").textContent =
      data.projectOverview.title || "Your Business";
    document.getElementById("conceptTagline").textContent =
      data.projectOverview.tagline || "A tagline for success";
    document.getElementById("conceptDescription").textContent =
      data.projectOverview.summary || "A detailed project summary.";

    // Populate metrics
    document.getElementById("metric-cost").textContent =
      data.estimates.cost || "$5,000 - $10,000";
    document.getElementById("metric-timeline").textContent =
      data.estimates.timeline || "4-6 Weeks";
    document.getElementById("metric-pages").textContent =
      data.sitemap?.pages.length || "10+";

    // Populate Branding
    const paletteContainer = document.getElementById("colorPalette");
    paletteContainer.innerHTML = "";
    if (data.visualIdentity && data.visualIdentity.colorPalette) {
      data.visualIdentity.colorPalette.forEach((color) => {
        paletteContainer.innerHTML += `
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-xl mx-auto mb-2 border-2 border-gray-600 shadow-inner" style="background-color: ${color.hex};"></div>
                        <div class="text-sm text-gray-200 font-semibold">${color.name}</div>
                        <div class="text-xs text-gray-400 font-mono">${color.hex}</div>
                        <div class="text-xs text-gray-500">${color.description}</div>
                    </div>`;
      });
    }

    const typographyContainer = document.getElementById("typography");
    typographyContainer.innerHTML = "";
    if (data.visualIdentity && data.visualIdentity.typography) {
      typographyContainer.innerHTML = `
                <div class="p-4 bg-gray-800/40 rounded-lg">
                    <div class="text-gray-400 text-sm mb-1">Heading Font</div>
                    <div class="text-white text-2xl" style="font-family: '${data.visualIdentity.typography.heading.font}', sans-serif;">${data.visualIdentity.typography.heading.font}</div>
                    <div class="text-gray-500 text-xs">${data.visualIdentity.typography.heading.description}</div>
                </div>
                <div class="p-4 bg-gray-800/40 rounded-lg">
                    <div class="text-gray-400 text-sm mb-1">Body Font</div>
                    <div class="text-white text-lg" style="font-family: '${data.visualIdentity.typography.body.font}', sans-serif;">${data.visualIdentity.typography.body.font}</div>
                    <div class="text-gray-500 text-xs">${data.visualIdentity.typography.body.description}</div>
                </div>
            `;
    }

    // Populate Sitemap
    const sitemapContainer = document.getElementById("sitemap-list");
    sitemapContainer.innerHTML = "";
    if (data.sitemap && data.sitemap.pages) {
      data.sitemap.pages.forEach((page) => {
        sitemapContainer.innerHTML += `<li>${page}</li>`;
      });
    }

    // Populate Wireframes
    const wireframesContainer = document.getElementById("wireframes-container");
    wireframesContainer.innerHTML = "";
    if (data.wireframes) {
      Object.entries(data.wireframes).forEach(([page, sections]) => {
        let sectionsHTML = sections
          .map(
            (section) => `
                    <div class="wireframe-section">
                        <div class="wireframe-title">${section.section}</div>
                        <p class="wireframe-description">${section.description}</p>
                    </div>
                `
          )
          .join("");

        wireframesContainer.innerHTML += `
                    <div class="mb-8">
                        <h4 class="wireframe-page-title">${page
                          .replace(/_/g, " ")
                          .replace(/\b\w/g, (l) => l.toUpperCase())}</h4>
                        ${sectionsHTML}
                    </div>
                `;
      });
    }

    // Scroll to results
    resultsSection.scrollIntoView({ behavior: "smooth", block: "start" });
  }

  function renderError(message) {
    document.getElementById("loading-section").classList.add("hidden");
    const resultsSection = document.getElementById("results-section");
    resultsSection.classList.remove("hidden");

    const content = `
            <div class="text-center text-red-400 bg-red-500/10 p-8 rounded-2xl glass">
                <h2 class="text-3xl font-bold text-white mb-4">Generation Failed</h2>
                <p class="text-lg text-red-300 mb-6">${message}</p>
                <button id="errorResetBtn" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-8 rounded-xl transition-colors">
                    Try Again
                </button>
            </div>
        `;
    resultsSection.innerHTML = content;

    document
      .getElementById("errorResetBtn")
      .addEventListener("click", resetGenerator);
    resultsSection.scrollIntoView({ behavior: "smooth", block: "start" });
  }

  // --- RESET FUNCTIONALITY ---

  function resetGenerator() {
    // Clear form data object
    formData = { features: [] };

    // This is a simple way to reload the form to its original state.
    // For a more complex SPA-like feel, you would manually reset each field.
    window.location.reload();
  }

  // --- INITIALIZATION ---
  initializeForm();
});

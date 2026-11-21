/* ==========================================================================
   ABOUT PAGE SCRIPT — Interactive Workflow Tabs
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
    const tabs = Array.from(document.querySelectorAll(".workflow-tab"));
    const workflowTitle = document.getElementById("workflowTitle");
    const workflowDescription = document.getElementById("workflowDescription");

    const workflowSteps = {
        discover: {
            title: "Discover & Filter Stories",
            description:
                "Start on the home feed to explore articles across categories like Programming, Web Development, Database, and Technology, or narrow down results using live search.",
        },
        create: {
            title: "Create & Preview Drafts",
            description:
                "Click the + button in the header to open the post editor, format your story content, watch the live card preview update as you type, and choose draft or published status.",
        },
        manage: {
            title: "Grow with Consistent UI & Accounts",
            description:
                "Move seamlessly between sign-in, sign-up, and legal pages while keeping your dark or light theme preference intact across every view.",
        },
    };

    tabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            const key = tab.dataset.tab;
            const step = key ? workflowSteps[key] : null;
            if (!step) return;

            tabs.forEach((t) => {
                const isSelected = t === tab;
                t.classList.toggle("active", isSelected);
                t.setAttribute("aria-selected", String(isSelected));
            });

            if (workflowTitle) workflowTitle.textContent = step.title;
            if (workflowDescription) workflowDescription.textContent = step.description;
        });
    });
});
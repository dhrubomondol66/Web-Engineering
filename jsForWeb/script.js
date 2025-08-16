
$(".nav-link").click(function (e) {
    e.preventDefault();
    let $this = $(this);
    let page = $this.data("page");

    if (page) {
        // Scroll smoothly to top of content (if desired)
        $('html, body').animate({ scrollTop: $('#content').offset().top }, 500);

        // Load content dynamically
        $("#content").load(page, function (response, status, xhr) {
            if (status === "error") {
                console.error(`Error loading page: ${xhr.status} ${xhr.statusText}`);
                $("#content").html("<p>Sorry, the page could not be loaded.</p>");
            } else {
                // Set active class AFTER content is loaded
                $(".nav-link").removeClass("active");
                $this.addClass("active");
            }
        });

        // Close mobile navbar if open
        $(".navbar-collapse").removeClass("show");
        $(".navbar-show-btn").show();
        $(".navbar-hide-btn").hide();
    }
});

    $(document).on("click", ".nav-link", function (e) {
        e.preventDefault();
        let page = $(this).data("page");
        if (page) {
            $("#content").load(page + "?partial=1"); // Always request partial
        }
    });

    // ✅ Handle filter links inside loaded pages (like Fever, Cardiology)
    // $(document).on("click", ".filter-link", function (e) {
    //     e.preventDefault();
    //     let url = $(this).attr("href");
    //     $("#content").load(url + "&partial=1"); // Ensure partial loading
    // });
    // Load navbar link pages via AJAX
    // $(document).on("click", ".nav-link", function (e) {
    //     e.preventDefault();
    //     let page = $(this).data("page");
    //     if (page) {
    //         $("#content").load(page + "?partial=1");
    //     }
    // });

    // ✅ Filter links like ?specialist=fever
    $(document).on("click", ".filter-link", function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        $("#content").load(url + "&partial=1");
    });

    // ✅ AJAX for Search Form submission
    $(document).on("submit", ".search-form", function (e) {
        e.preventDefault();
        const form = $(this);
        const action = form.attr("action");
        const query = form.serialize(); // Includes specialist if present
        $("#content").load(action + "?" + query + "&partial=1");
    });

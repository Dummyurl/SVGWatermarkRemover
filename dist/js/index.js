document.addEventListener("DOMContentLoaded", () => {

    let content = document.querySelector("#content");
    let result = document.querySelector("#result");

    let url = "index.php";
    var interval;
    document.forms[0].addEventListener("submit", (e) => {
        e.preventDefault();
        content.innerHTML = getProgressBarIndeterminate();

        let progress = document.querySelector("#progress");
        updateProgressBar(progress);
        interval = setInterval(() => updateProgressBar(progress), 200);

        updateProgressBar(progress);

        let formData = new FormData(e.target);
        formData.append("submit", "ok");
        postForm(formData);
    });

    function updateProgressBar(progress) {

        fetch('dist/json/progress.json')
            .then((res) => {
                return res.json();
            })
            .then((json) => {
                progress.setAttribute("aria-valuenow", json.status);
                progress.style.width = json.status + "%";
                console.log("progress = " + json.status);
            })
            .catch((rej) => {
                console.log(rej);
            });

    }

    function getProgressBarIndeterminate() {
        return `<div class="progress">
    <div id="progress"
         class="progress-bar progress-bar-striped progress-bar-animated"
         role="progressbar"
         aria-valuenow="0"
         aria-valuemin="0"
         aria-valuemax="100"
         style="width: 0%">
    </div>
</div>`;
    }

    function postForm(formData) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", url);
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                result.innerHTML = `<a href="output/starUML.zip" class="btn btn-secondary" download>Download</a>`;
                content.innerHTML = xhr.response;
                clearInterval(interval);
            }
        }
        xhr.send(formData);
    }
});

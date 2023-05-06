<section class="container-fluid bg-light py-5">
    <div class="container">
        <div class="row">
            <?php (new class { use CustomersUtils; })::getTitle('customer', $param); ?>
        </div>
    </div>
</section>
<section class="container-fluid px-md-4 py-1">
    <div class="container">
        <div class="row">
            <div class="col-12 p-4 my-4 shadow">
                <h3 class="mb-3"><span class="material-symbols-outlined">kitesurfing</span> Descobertas das semana </h3>
                <div id="carouselExampleCaptions" class="carousel slide">
                    <div class="carousel-indicators" style="width: 100%;left: 0;margin: 0;bottom: -15px;">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active bg-dark" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" class="bg-dark" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" class="bg-dark" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-4 p-4">
                                    <div class="card shadow">
                                        <img style="object-fit: cover; height: 13vw;" src="data:image/jpeg;base64,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" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 p-4">
                                    <div class="card shadow">
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoNb-_HhHMR6sr37ginUbCEijKNFGSTtbC7A&usqp=CAU" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 p-4">
                                    <div class="card shadow">
                                        <img style="object-fit: cover; height: 13vw;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwZfOinOmKTNZpgGenapI16KPHklR11eed3Q&usqp=CAU" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-4 p-4">
                                    <div class="card shadow">
                                        <img style="object-fit: cover; height: 13vw;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJYgebmeBnEY-26zZr7Sm00rgVeB58Ifm4LQ&usqp=CAU" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 p-4">
                                    <div class="card shadow">
                                        <img style="object-fit: cover; height: 13vw;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQy3yTZTxuzXj3JqiuVChEQ0fsiKze9gMjFBg&usqp=CAU" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 p-4">
                                    <div class="card shadow">
                                        <img style="object-fit: cover; height: 13vw;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRv-X5esE9yI4OfA6c3juaVpUwaKSrbE-8cwQ&usqp=CAU" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-4 p-4">
                                    <div class="card shadow">
                                        <img style="object-fit: cover; height: 13vw;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQaKBme7Sb4xi3OdRG0nzmMSnZQnttcfUYdkQ&usqp=CAU" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 p-4">
                                    <div class="card shadow">
                                        <img style="object-fit: cover; height: 13vw;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSsRT5Z8Lb4Allfm57wkcpfa77T8gbFjX7lBg&usqp=CAU" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 p-4">
                                    <div class="card shadow">
                                        <img style="object-fit: cover; height: 13vw;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTqFY_ukQmfMYz0mbKd15DEK7WVBM3KKFDyrg&usqp=CAU" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-4 p-0">
                <div class="card rounded-0 border-0 mb-3 shadow">
                    <div class="card-header"><h3><span class="material-symbols-outlined">favorite</span> Favoritos </h3> </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <img style="width: 6vw; height: 60px; object-fit: cover;" class="img-thumbnail" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRawbpXAb0fJxtSgJuxNXdgcQIhxdr_W39QDz5MoT5vWc-2rSU7x83YbOts0n3DnSKqJfQ&usqp=CAU" alt="...">
                                An item
                            </li>
                            <li class="list-group-item">
                                <img  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQo5_LcnYdNVTSF_-onJ3hlNf93Dr5n4R2CBxPuu7kihttpnv3yjcaGmHfE7KXiHTeqK0k&usqp=CAU"  style="width: 6vw; height: 60px; object-fit: cover;" class="img-thumbnail" alt="...">
                                A second item</li>
                            <li class="list-group-item">
                                <img  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQUpQcA4YAEbDcUSUeTjaqNGIGpVD-1Pk2UFA&usqp=CAU"  style="width: 6vw; height: 60px; object-fit: cover;" class="img-thumbnail" alt="...">
                                A third item</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-8 p-0 ps-md-4">
                <div class="card rounded-0 border-0 mb-3 shadow">
                    <div class="card-header"><h3><span class="material-symbols-outlined">update</span> Histórico </h3> </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4 position-relative">
                                        <img style="width: 100%; height: 100%; object-fit: cover;"  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSD651Dn9t0MpFD9JLp8CbP1R-S4O5Ak9OJpw&usqp=CAU" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Card title</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4 position-relative">
                                        <img style="width: 100%; height: 100%; object-fit: cover;"  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSc3bN6wvBK7_YYevXivnDiGhDh81B96LGtxw&usqp=CAU" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Card title</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

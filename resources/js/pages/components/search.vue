<template>
    <form action="#">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <slot></slot>
                <div class="form-group">
                    <div class="input-group input-group-lg">
                        <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here" value="">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

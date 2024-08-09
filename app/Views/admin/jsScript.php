
<script type="text/javascript">
    $("document").ready(function() {
        $("#dtPublikasi").DataTable({
            ordering: true, 
            destroy: true,
            pageLength: 5,
            ajax: {
                url: "/api/admin/publikasi/list",
                dataSrc: ""
            },
            columns: [
                { data: "tahun" },
                { data: "judul_publikasi" },
                { data: "jenis" },
                { data: "nama_journal_conf" },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return [
                            "<ul class='d-flex list-inline mb-0'  style='gap: 12px;'>",
                                "<li class='list-inline-item'>",
                                    "<a ",
                                        "class='p-0 border-0 bg-transparent text-primary'",
                                        `href='/publikasi/view/${row.id}'`,
                                    ">",
                                        "<i class='uil uil-eye font-size-18'></i>",
                                    "</a>",
                                "</li>",
                                "<li class='list-inline-item'>",
                                    "<button ",
                                        "class='p-0 border-0 bg-transparent text-primary'",
                                        `onclick="window.location = '/admin/publikasi/update/${row.id}'"`,
                                    ">",
                                        "<i class='uil uil-pen font-size-18'></i>",
                                    "</button>",
                                "</li>",
                                "<li class='list-inline-item'>",
                                    "<button ",
                                        "class='p-0 border-0 bg-transparent text-danger'",
                                        `onclick="window.location = '/admin/publikasi/delete/${row.id}'"`,
                                    ">",
                                        "<i class='uil uil-trash-alt font-size-18'></i>",
                                    "</button>",
                                "</li>",
                            "</ul>",
                        ].join(" ")
                    }
                }
            ]
        });

        $("#dtPenelitian").DataTable({
            ordering: true, 
            destroy: true,
            pageLength: 5,
            ajax: {
                url: "/api/admin/penelitian/list",
                dataSrc: ""
            },
            columns: [
                { data: "tahun" },
                { data: "jenis" }, 
                { data: "nama_kegiatan" },
                { data: "judul_penelitian" },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return [
                            "<ul class='d-flex list-inline mb-0' style='gap: 12px;'>",
                                "<li class='list-inline-item'>",
                                    "<a ",
                                        "class='p-0 border-0 bg-transparent text-primary'",
                                        `href="/penelitian/view/${row.id}"`,
                                    ">",
                                        "<i class='uil uil-eye font-size-18'></i>",
                                    "</a>",
                                "</li>",
                                "<li class='list-inline-item'>",
                                    "<button ",
                                        "class='p-0 border-0 bg-transparent text-primary'",
                                        `onclick="window.location = '/admin/penelitian/update/${row.id}'"`,
                                    ">",
                                        "<i class='uil uil-pen font-size-18'></i>",
                                    "</button>",
                                "</li>",
                                "<li class='list-inline-item'>",
                                    "<button ",
                                        "class='p-0 border-0 bg-transparent text-danger'",
                                        `onclick="window.location = '/admin/penelitian/delete/${row.id}'"`,
                                    ">",
                                        "<i class='uil uil-trash-alt font-size-18'></i>",
                                    "</button>",
                                "</li>",
                            "</ul>",
                        ].join(" ")
                    }
                }
            ]
        });

        $("#dtAbdimas").DataTable({
            ordering: true, 
            destroy: true,
            pageLength: 5,
            ajax: {
                url: "/api/admin/abdimas/list",
                dataSrc: ""
            },
            columns: [
                { data: "tahun" },
                { data: "jenis" },
                { data: "nama_kegiatan" },
                { data: "judul" }, 
                { 
                    data: null,
                    render: function(data, type, row) {
                        return [
                            "<ul class='d-flex list-inline mb-0' style='gap: 12px;'>",
                                "<li class='list-inline-item'>",
                                    "<a ",
                                        "class='p-0 border-0 bg-transparent text-primary'",
                                        `href="/abdimas/view/${row.id}"`,
                                    ">",
                                        "<i class='uil uil-eye font-size-18'></i>",
                                    "</a>",
                                "</li>",
                                "<li class='list-inline-item'>",
                                    "<button ",
                                        "class='p-0 border-0 bg-transparent text-primary'",
                                        `onclick="window.location = '/admin/abdimas/update/${row.id}'"`,
                                    ">",
                                        "<i class='uil uil-pen font-size-18'></i>",
                                    "</button>",
                                "</li>",
                                "<li class='list-inline-item'>",
                                    "<button ",
                                        "class='p-0 border-0 bg-transparent text-danger'",
                                        `onclick="window.location = '/admin/abdimas/delete/${row.id}'"`,
                                    ">",
                                        "<i class='uil uil-trash-alt font-size-18'></i>",
                                    "</button>",
                                "</li>",
                            "</ul>",
                        ].join(" ")
                    }
                }
            ]
        });

        $("#dtHaki").DataTable({
            ordering: true, 
            destroy: true,
            pageLength: 5,
            ajax: {
                url: "/api/admin/haki/list",
                dataSrc: ""
            },
            columns: [
                { data: "tahun" },
                { data: "jenis" },
                { data: "judul" },
                { data: "no_pendaftaran" },
                { data: "no_sertifikat" },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return [
                            "<ul class='d-flex list-inline mb-0' style='gap: 12px;'>",
                                "<li class='list-inline-item'>",
                                    "<a ",
                                        "class='p-0 border-0 bg-transparent text-primary'",
                                        `href="/haki/view/${row.id}"`,
                                    ">",
                                        "<i class='uil uil-eye font-size-18'></i>",
                                    "</a>",
                                "</li>",
                                "<li class='list-inline-item'>",
                                    "<button ",
                                        "class='p-0 border-0 bg-transparent text-primary'",
                                        `onclick="window.location = '/admin/haki/update/${row.id}'"`,
                                    ">",
                                        "<i class='uil uil-pen font-size-18'></i>",
                                    "</button>",
                                "</li>",
                                "<li class='list-inline-item'>",
                                    "<button ",
                                        "class='p-0 border-0 bg-transparent text-danger'",
                                        `onclick="window.location = '/admin/haki/delete/${row.id}'"`,
                                    ">",
                                        "<i class='uil uil-trash-alt font-size-18'></i>",
                                    "</button>",
                                "</li>",
                            "</ul>",
                        ].join(" ")
                    }
                }
            ]
        });
    })
</script>
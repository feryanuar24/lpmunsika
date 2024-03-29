import Footer from "@/Components/Footer";
import NavBar from "@/Components/NavBar";
import Sportify from "@/Components/Sportify";
import Youtube from "@/Components/Youtube";
import { Head } from "@inertiajs/inertia-react";
import React from "react";

export default function PedomanLayout({ categories, sportifies, slug }) {
    return (
        <>
            <Head title="Pedoman Media Siber" />

            <NavBar categories={categories} slug={slug} />

            <div className="xl:px-28 xl:grid xl:grid-cols-3">
                <section className="p-5 xl:col-span-2">
                    <article>
                        <figcaption className="text-justify">
                            <h2 className="font-bold text-xl xl:text-3xl border-b-8 w-max border-red-500 uppercase">
                                Pedoman Media Siber
                            </h2>
                            <hr />
                            <p className="pt-10">
                                Kemerdekaan berpendapat, kemerdekaan
                                berekspresi, dan kemerdekaan pers adalah hak
                                asasi manusia yang dilindungi Pancasila,
                                Undang-Undang Dasar 1945, dan Deklarasi
                                Universal Hak Asasi Manusia PBB. Keberadaan
                                media siber di Indonesia juga merupakan bagian
                                dari kemerdekaan berpendapat, kemerdekaan
                                berekspresi, dan kemerdekaan pers.
                            </p>
                            <p className="pt-5">
                                Media siber memiliki karakter khusus sehingga
                                memerlukan pedoman agar pengelolaannya dapat
                                dilaksanakan secara profesional, memenuhi
                                fungsi, hak, dan kewajibannya sesuai
                                Undang-Undang Nomor 40 Tahun 1999 tentang Pers
                                dan Kode Etik Jurnalistik. Untuk itu Dewan Pers
                                bersama organisasi pers, pengelola media siber,
                                dan masyarakat menyusun Pedoman Pemberitaan
                                Media Siber sebagai berikut:
                            </p>
                            <ol className="pt-5 list-decimal pl-5">
                                <li className="font-bold">Ruang Lingkup</li>
                                <p>
                                    Media Siber adalah segala bentuk media yang
                                    menggunakan wahana Internet dan melaksanakan
                                    kegiatan jurnalistik, serta memenuhi
                                    persyaratan Undang-Undang Pers dan Standar
                                    Perusahaan Pers yang ditetapkan Dewan Pers.
                                    Isi Buatan Pengguna (User Generated Content)
                                    adalah segala isi yang dibuat dan atau
                                    dipublikasikan oleh pengguna media siber,
                                    antara lain, artikel, gambar, komentar,
                                    suara, video dan berbagai bentuk unggahan
                                    yang melekat pada media siber, seperti blog,
                                    forum, komentar pembaca atau pemirsa, dan
                                    bentuk lain.
                                </p>
                                <li className="font-bold pt-5">
                                    Verifikasi dan keberimbangan berita
                                </li>
                                <ol className="list-disc pl-5">
                                    <li>
                                        Pada prinsipnya setiap berita harus
                                        melalui verifikasi.
                                    </li>
                                    <li>
                                        Berita yang dapat merugikan pihak lain
                                        memerlukan verifikasi pada berita yang
                                        sama untuk memenuhi prinsip akurasi dan
                                        keberimbangan.
                                    </li>
                                    <li>
                                        Ketentuan dalam butir (a) di atas
                                        dikecualikan, dengan syarat:
                                    </li>
                                    <ol className="list-decimal pl-5">
                                        <li>
                                            Berita benar-benar mengandung
                                            kepentingan publik yang bersifat
                                            mendesak;
                                        </li>
                                        <li>
                                            Sumber berita yang pertama adalah
                                            sumber yang jelas disebutkan
                                            identitasnya, kredibel dan kompeten;
                                        </li>
                                        <li>
                                            Subyek berita yang harus
                                            dikonfirmasi tidak diketahui
                                            keberadaannya dan atau tidak dapat
                                            diwawancarai;
                                        </li>
                                        <li>
                                            Media memberikan penjelasan kepada
                                            pembaca bahwa berita tersebut masih
                                            memerlukan verifikasi lebih lanjut
                                            yang diupayakan dalam waktu
                                            secepatnya. Penjelasan dimuat pada
                                            bagian akhir dari berita yang sama,
                                            di dalam kurung dan menggunakan
                                            huruf miring.
                                        </li>
                                    </ol>
                                    <li>
                                        Setelah memuat berita sesuai dengan
                                        butir (c), media wajib meneruskan upaya
                                        verifikasi, dan setelah verifikasi
                                        didapatkan, hasil verifikasi dicantumkan
                                        pada berita pemutakhiran (update) dengan
                                        tautan pada berita yang belum
                                        terverifikasi.
                                    </li>
                                </ol>
                                <li className="font-bold pt-5">
                                    Isi Buatan Pengguna (User Generated Content)
                                </li>
                                <ol className="list-disc pl-5">
                                    <li>
                                        Media siber wajib mencantumkan syarat
                                        dan ketentuan mengenai Isi Buatan
                                        Pengguna yang tidak bertentangan dengan
                                        Undang-Undang No. 40 tahun 1999 tentang
                                        Pers dan Kode Etik Jurnalistik, yang
                                        ditempatkan secara terang dan jelas.
                                    </li>
                                    <li>
                                        Media siber mewajibkan setiap pengguna
                                        untuk melakukan registrasi keanggotaan
                                        dan melakukan proses log-in terlebih
                                        dahulu untuk dapat mempublikasikan semua
                                        bentuk Isi Buatan Pengguna. Ketentuan
                                        mengenai log-in akan diatur lebih
                                        lanjut.
                                    </li>
                                    <li>
                                        Dalam registrasi tersebut, media siber
                                        mewajibkan pengguna memberi persetujuan
                                        tertulis bahwa Isi Buatan Pengguna yang
                                        dipublikasikan:
                                    </li>
                                    <ol className="list-decimal pl-5">
                                        <li>
                                            Tidak memuat isi bohong, fitnah,
                                            sadis dan cabul;
                                        </li>
                                        <li>
                                            Tidak memuat isi yang mengandung
                                            prasangka dan kebencian terkait
                                            dengan suku, agama, ras, dan
                                            antargolongan (SARA), serta
                                            menganjurkan tindakan kekerasan;
                                        </li>
                                        <li>
                                            Tidak memuat isi diskriminatif atas
                                            dasar perbedaan jenis kelamin dan
                                            bahasa, serta tidak merendahkan
                                            martabat orang lemah, miskin, sakit,
                                            cacat jiwa, atau cacat jasmani.
                                        </li>
                                    </ol>
                                    <li>
                                        Media siber memiliki kewenangan mutlak
                                        untuk mengedit atau menghapus Isi Buatan
                                        Pengguna yang bertentangan dengan butir
                                        (c). Media siber wajib menyediakan
                                        mekanisme pengaduan Isi Buatan Pengguna
                                        yang dinilai melanggar ketentuan pada
                                        butir (c). Mekanisme tersebut harus
                                        disediakan di tempat yang dengan mudah
                                        dapat diakses pengguna.
                                    </li>
                                    <li>
                                        Media siber wajib menyunting, menghapus,
                                        dan melakukan tindakan koreksi setiap
                                        Isi Buatan Pengguna yang dilaporkan dan
                                        melanggar ketentuan butir (c), sesegera
                                        mungkin secara proporsional
                                        selambat-lambatnya 2 x 24 jam setelah
                                        pengaduan diterima.
                                    </li>
                                    <li>
                                        Media siber yang telah memenuhi
                                        ketentuan pada butir (a), (b), (c), dan
                                        (f) tidak dibebani tanggung jawab atas
                                        masalah yang ditimbulkan akibat pemuatan
                                        isi yang melanggar ketentuan pada butir
                                        (c).
                                    </li>
                                    <li>
                                        Media siber bertanggung jawab atas Isi
                                        Buatan Pengguna yang dilaporkan bila
                                        tidak mengambil tindakan koreksi setelah
                                        batas waktu sebagaimana tersebut pada
                                        butir (f).
                                    </li>
                                </ol>
                                <li className="font-bold pt-5">
                                    Ralat, Koreksi, dan Hak Jawab
                                </li>
                                <ol className="list-disc pl-5">
                                    <li>
                                        Ralat, koreksi, dan hak jawab mengacu
                                        pada Undang-Undang Pers, Kode Etik
                                        Jurnalistik, dan Pedoman Hak Jawab yang
                                        ditetapkan Dewan Pers.
                                    </li>
                                    <li>
                                        Ralat, koreksi dan atau hak jawab wajib
                                        ditautkan pada berita yang diralat,
                                        dikoreksi atau yang diberi hak jawab.
                                    </li>
                                    <li>
                                        Di setiap berita ralat, koreksi, dan hak
                                        jawab wajib dicantumkan waktu pemuatan
                                        ralat, koreksi, dan atau hak jawab
                                        tersebut.
                                    </li>
                                    <li>
                                        Bila suatu berita media siber tertentu
                                        disebarluaskan media siber lain, maka:
                                    </li>
                                    <ol className="list-decimal pl-5">
                                        <li>
                                            Tanggung jawab media siber pembuat
                                            berita terbatas pada berita yang
                                            dipublikasikan di media siber
                                            tersebut atau media siber yang
                                            berada di bawah otoritas teknisnya;
                                        </li>
                                        <li>
                                            Koreksi berita yang dilakukan oleh
                                            sebuah media siber, juga harus
                                            dilakukan oleh media siber lain yang
                                            mengutip berita dari media siber
                                            yang dikoreksi itu;
                                        </li>
                                        <li>
                                            Media yang menyebarluaskan berita
                                            dari sebuah media siber dan tidak
                                            melakukan koreksi atas berita sesuai
                                            yang dilakukan oleh media siber
                                            pemilik dan atau pembuat berita
                                            tersebut, bertanggung jawab penuh
                                            atas semua akibat hukum dari berita
                                            yang tidak dikoreksinya itu.
                                        </li>
                                    </ol>
                                    <li>
                                        Sesuai dengan Undang-Undang Pers, media
                                        siber yang tidak melayani hak jawab
                                        dapat dijatuhi sanksi hukum pidana denda
                                        paling banyak Rp500.000.000 (Lima ratus
                                        juta rupiah).
                                    </li>
                                </ol>
                                <li className="font-bold pt-5">
                                    Pencabutan Berita
                                </li>
                                <ol className="list-disc pl-5">
                                    <li>
                                        Berita yang sudah dipublikasikan tidak
                                        dapat dicabut karena alasan penyensoran
                                        dari pihak luar redaksi, kecuali terkait
                                        masalah SARA, kesusilaan, masa depan
                                        anak, pengalaman traumatik korban atau
                                        berdasarkan pertimbangan khusus lain
                                        yang ditetapkan Dewan Pers.
                                    </li>
                                    <li>
                                        Media siber lain wajib mengikuti
                                        pencabutan kutipan berita dari media
                                        asal yang telah dicabut.
                                    </li>
                                    <li>
                                        Pencabutan berita wajib disertai dengan
                                        alasan pencabutan dan diumumkan kepada
                                        publik.
                                    </li>
                                </ol>
                                <li className="font-bold pt-5">Iklan</li>
                                <ol className="list-disc pl-5">
                                    <li>
                                        Media siber wajib membedakan dengan
                                        tegas antara produk berita dan iklan.
                                    </li>
                                    <li>
                                        Setiap berita/artikel/isi yang merupakan
                                        iklan dan atau isi berbayar wajib
                                        mencantumkan keterangan "advertorial",
                                        "iklan", "ads", "sponsored", atau kata
                                        lain yang menjelaskan bahwa
                                        berita/artikel/isi tersebut adalah
                                        iklan.
                                    </li>
                                </ol>
                                <li className="font-bold pt-5">Hak Cipta</li>
                                <p>
                                    Media siber wajib menghormati hak cipta
                                    sebagaimana diatur dalam peraturan
                                    perundang-undangan yang berlaku.
                                </p>
                                <li className="font-bold pt-5">
                                    Pencantuman Pedoman
                                </li>
                                <p>
                                    Media siber wajib mencantumkan Pedoman
                                    Pemberitaan Media Siber ini di medianya
                                    secara terang dan jelas.
                                </p>
                                <li className="font-bold pt-5">Sengketa</li>
                                <p>
                                    Penilaian akhir atas sengketa mengenai
                                    pelaksanaan Pedoman Pemberitaan Media Siber
                                    ini diselesaikan oleh Dewan Pers.
                                </p>
                            </ol>
                            <p className="pt-10">Jakarta, 3 Februari 2012</p>
                            <p className="pt-5">
                                (Pedoman ini ditandatangani oleh Dewan Pers dan
                                komunitas pers di Jakarta, 3 Februari 2012).
                            </p>
                        </figcaption>
                    </article>
                </section>

                <div className="xl:col-span-1">
                    <Youtube />

                    <Sportify sportifies={sportifies} />
                </div>
            </div>

            <Footer categories={categories} slug={slug} />
        </>
    );
}

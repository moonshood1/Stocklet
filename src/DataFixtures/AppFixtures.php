<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);


        $loulou = new User();   
        $loulou->setFirstName('Louis Roger')
             ->setLastName('Guirika')
             ->setEmail('louisroger@live.fr')
             ->setPassword($this->encoder->encodePassword($loulou,'12345678'))
             ->setAddress('Deux plateaux Duncan Apres CEI')
             ->setUserPhone('08990169')
             ->addUserRole($adminRole);

             $manager->persist($loulou);

        $category = new Category();
        $category->setCategoryName("Téléphones Portables");
        $manager->persist($category);

        $product = new Product();
        $product->setProductName("Galaxy S20 +")
                ->setproductDescription1("Le Samsung Galaxy S20 est un smartphone haut de gamme de Samsung annoncé en février 2020 et disponible début mars 2020 qui succède au Galaxy S10")
                ->setProductDescription2("Il est équipé d'un écran AMOLED de 6,2 pouces certifié HDR10+, d'un triple capteur photo polyvalent entre ultra grand-angle et zoom 3X (30X en hybride) et d'un processeur Exynos 990 gravé en 7 nm épaulé par 8 Go de RAM (12 Go en version 5G). Il est disponible en version 4G ou 4G+5G et avec 128 Go de stockage UFS 3.0.")
                ->setUnitPrice(450000)
                ->setOldUnitPrice(485000)
                ->setBrand("Samsung")
                ->setProductAvailable(true)
                ->setInitialStock(7)
                ->setCurrentStock(7)
                ->setSpec1Title("Un énorme bond en avant en matière de résolution et de zoom pour la photographie mobile")
                ->setSpec1("La résolution de 108 MP vous permet de zoomer, encore et encore.Bien au-delà de la catégorie des 12 mégapixels, le Galaxy S20 Ultra vous offre des millions de pixels supplémentaires sur chaque photo. Ainsi, pour la première fois, vous pouvez observer des détails que vous n'auriez jamais vus auparavant.")
                ->setSpec2Title("Que vienne la nuit")
                ->setSpec2("Lorsque la luminosité est faible, le système d’appareil photo de qualité professionnelle prend plusieurs photos à la fois, en les fusionnant en une seule image époustouflante, où le flou et le bruit sont atténués. Les capteurs d'image plus importants et l’IA vous permettent d’immortaliser des scènes nocturnes aussi nettes qu’en plein jour grâce au mode Nuit")
                ->setSpec3Title("La prise de vue vidéo en 8K révolutionne vos photos et vidéos")
                ->setSpec3("Nous avons fait évoluer la résolution mobile, en passant de 4K à 8K. C'est 4 fois plus important que l'UHD et 16 fois mieux que la FHD. Cette résolution vous permet donc d’immortaliser des moments à l’aide d’une résolution ultra-nette.")
                ->setEndDate(new \DateTime("2020-11-28T15:00:01+00:00"))
                ->setCreatedAt(new \DateTime())
                ->setCategory($category)
                ->setLeftPic1URL("https://lh3.googleusercontent.com/tvShgvs89gbAT7MMCX95DgdG-faPh7Oc58GffScxlOGpyPOAidwelBes9Oq2MvluSb8F2X9OrRS-v456ediztcFNCNTrjIJjCzd1ORTqdIHWrM56PzvxRQRNt4dWX-mznbIPeO4IhPlJwXDQZ3jHQbLLzK_6xgwxkPuTXAENKCHWSaYsvMWmcgkfFYaTJvSjrQGFdXOJGezT6hNmbF-qK2z-cGCLwhyTy6JD7zneGsMt8HHs9W824TXAUUXcFbmg5QREpn7eMbof5LIY7sgnScx0Bz1KQXbKGG1YrVh26ZbDI5BokER1HLuwlvngixXL3G4GrK0o7DZKyrmA6tmoGMMSsubmUCGZ0kxlTAzyRsj_pDzgduP6M0rmdTHGhXSgM5QpthCm-8V4I3AcADPyTSSI2EcaSXKvySvpktb6Es8Bpw0-6uS-JgScZ8GBRBz-rbUCIC3jxJEQ7iyOrq6f-DGuszzVNs5xi-gwRfDvXiBhAgYU5JL6UDCIdX830ocCp2RJRuaaul_KlMvUYSQKUHw8LEE_t4Il8BoS-uDeulCebfHFn0E5317WepygpmLuoEOJXgCgBbYeyUD_8nRghNd_dOZ7wegRmMZRrkkc6mZ784eEw-IrfN0iHUaVQHBjQVCtHgVE2kcO4TcitFRmUfJbgEYP_kxIdTfmeiEyN247OFDujJ3vjeAg9fat2w=s800-no?authuser=0")
                ->setLeftPic2URL("https://lh3.googleusercontent.com/-A10H6jxZd5b_-QBw5ezU38ol96i5Ylm3NhF5VlQgJfW0bSqLIk8KcwT0TSSFWmnl4L6oEkT0ulsUcCFmFx0y5TO4qJq5wh-e97ZEIxyoiXVDmb8sYEQmx0HgoeKxhMjRBrDDjvYKQpASS_O-h5Dac4Fm31K3oY3Tq0fn4EHPwT_RZJaL4TEp6RPpiZdku7SUfL8qDXYAqlMwrumWTlECJZtTNIkB7h5d_qMNGxPq6GjGoMoOHAMdvOXBTTL3pl2UfEyeW9wUK83m9na0EhyVGTKQBdTPovKphXoFmXJ2yB1jpRGD-KfUhlmZJ2uQBerP5myZ5MxkVkL8DMLdyMbl71tYgVRyvjdOxp7avNavkTH68obcQJ_Vj49qrabrtfAjuT4FzCY3q9jZznBQLU4XHr80Pq_VtcazAzAh83BfSpft2xqIzbVAETt5gv9aiaXXdvUKxU_FaCPE698DxZS5a4u2g3EK9mA2_RNgxPxxD_5B7wfGkcYNk4_uD_P5hH4M15IYV5TVNtnPGb9tnwUVo2z_A0mpJIyRjODyRgxqANwjmmiKgFbBJ4gWfcpeoEMTKWVgj9S-_LRnl0tv9pRvtvKnv4FJ6B9ye6nSatSVBrksZDhvS1EwuQ-iL3BOrIMNrxQy3HE3MdPUQDMTCFHkLrbJF7MZ-TZ-CpejSc-pHhBXRARdAMLMWw8JHRRfw=s800-no?authuser=0")
                ->setLeftPic3URL("https://lh3.googleusercontent.com/6fEfQqioA46k5Xz6uJ8UoXK1W1ukadBYCAwUks9278QiUo0jLVmcks53dXTzFeg512aXmSsB4rTfLfvgZJWgTO0OdxDcduZ2btUCiCanRJ5yNL4Pw1FlioRzV7CD4s2k9iiAdzasD_Mqbb8vF5o_gMDTqYLDgiwLCoDvSqCi22mEB_y1XqQHPML5XkWzWgU0XiR1h84eNp8Qb0a_O76K4c2YI8BcvPNFSSfuHgj3BYAOS_LBabyusGDPyi-DWBgDL9WOAKBDTzfGypoy3eyeqKFfhoXTv9gN_3osUOrzVy8jTkeWMq-RLiblw36Cew5OY4JHM_1q2CjYbXA8EW1lntkn0R8ERG7kX1SpCezrH2YaDkQO5tzumSAfWpo5zmDWv2If33OrTUqR7ssRrQ06LeTvRsJK-EHSh_8AcaBP83L5gYJGTjJrJ2wW7eoBEE5uxVHHkM8sqA5itYGVe0DFGgS24EXOPi5KNP8SPt2fTKT-T8NVNEGQ-O7graEEDtjWVMgKLGJcqkBPaGkiDex-se2NIxejXbbndY1r6KXVSifZM49wnX2u5BLwnUtA0HREynEa0mxNqqVwQDNQZU9Hgo7eZ2ZAyuF5USZegmkkmzkRi4nN0qWeM0NO7_vFeAL5rOycAxsVbLN0TMc_HPs4Fa6wwSYc1uhY8iyVAH9-RczMhwoI_kf0Gi43r-jZGg=s800-no?authuser=0")
                ->setRightPic1Url("https://lh3.googleusercontent.com/a5YXvOZyc5NDuUmHqBCruwLW8FuF710nH7B2m-WMHJWCxZikSMxB-SXLiCdgGBPRw80frqZMvHHJqr7_1PrFRMIpCJs8zuAn-UbhcnjEFMF4VlWvnvHwsxGL2zEzpaZGQskTO7HRROE-88F-3af3kdX8rdazGAIdH-zMWVrXPq2HGdiB-xoOoDUTSigPe_MwKP3sP10jerDUomjkcDKQN1dQU9Z4EwPtfmSPI6uf1_JDfhTDBbyoaFXKMUtTQQ_s6EKY-vJvCm9WwnQL0IWSVvxValJKc1Vl9g3cPftG3Yjkbj1ztprYcTPi-uihMCO9zsVHWTTtaXg12pDmoKMBPD7C58zQ-1B1KLWBNbIfY-L1VhaRzSHnSdtwGtanfTVeWKiJX0qSoblsVxN3B6FGC8633qbffOEbjzxujy0T9fHdd_9v3f61Lx_uHJzU38uMT1pUiyyLDv8nKmTu8m6-0Ql3pePFOMS9v2AQEx34DmYytzj5ylFdeR93LO__ub8DMThr3xmF9PM5YsCoZgGNA-MI5DgSdING-WcyxCymogZ-S8YklisMC4sjRK6mdARpTscPGGFdUAybpW6Bt-2g7goRyjnamq8bKVsnpyOgHKGr6bQjVCpC0pBepHDukzarz-V5aRD8FNVXrT4d0qUuzNdduC4uCygq1RI9bA3coUktpXXPZUFdpWJCFMifVA=w235-h170-no?authuser=0")
                ->setRightPic2Url("https://lh3.googleusercontent.com/hj54IJdFDOUNfBkzk3eO6YKWH3RybmcH7cAvwAf6wJb-e7cyzTIku3SP8c_HswbRd6bq347RYS_iJqeNU9OphyKPOqsN0txSHX6pu4a9n30c9y074EPhcBZqgb1j-7030h_hCUz7HDsTGJ4Xqvts_xaDmdUHANBrLSHUazRUJsN32-GeJkUnsthvFblU3CIc6pQfAtaTuJ7PF1mmAPhGZYusYdnYHAlg5U-HmMesq4aSPSIUDlrXvfnoBoXDaZ9cVNZTWlqkyOXdh19-8gCKlcNYdQxRIZhq0Rf4kmCLWdu-48IY8ChPMEd9-q37fyLYIbzwc52w_wAwEOTzNuFnLRcpq-T-mU7pXzgpgQ5yvcUMZRgmdDmQqvN6Nu1Nm9CbPab6EZLTVhKZCsMMBsiKSqhR5Eglp9fUZYEkZjmJWyvlx210ipvqc9gZWNEZ4JNDWMyr1gIc-eghw10vTkKZyZG_HnvbdL-hMBtls9y_WwK_5OMEvBCosVEKivBKV7DT_onMECIzkcTgoAfBpZgpD7v-tkWg1ND80GV_Qnh3h1ljLBL4H7kfrJxxuM-oDC3Vv_0C6dyqfyhirVSKEVqNmoYEuObj5jQyz8wq9GRDun1RzPMzPduk4-C0ZVlw3GeUYEY_SpLJfIgIM-1bZSW4Hk6Ok0uwoUxsQGRYRRvK0FxpGoQ78HRdOCzd1JoFcA=w235-h170-no?authuser=0")
                ->setRightPic3Url("https://lh3.googleusercontent.com/dPOBD1lVtzZ4CWrnbz8X_EulAiLhkZNrVOUC7SksPNe8exGeWNz2L18UlbfaclzwOC0rvO2Z6xRHBSL8OcS54Ype2FEehPCOxElG2aU4K0odQD1sPQWNqsYGDFYt5sibL5ZcgkDDHL6BQeO-LotoXpFpNkFuPh_d1kXdj5ibZMIYVky8kGxhvBBFeh6PAErZuCWKQm2YUIxyIUoPI2tfAR3VYBc8fxgtgE7CvwhMw4msbsooJoEmgz-wZXXsjfAylUol9bVHyPdJismDV1x7E-yJQ15xZt6sIuqaKw4ogkDtukaf6PLUKtI3pv2skYw6Rzy9YtN3oVgeIGAwuOSA2k-fw2eY_qcWCuYaNX59GRHncfmUnyx0qvMs1AKysBoRRcHzBYcguyBMmYmsJ3i7f4nBcwkPSXkmRom2J4ughWQLRF-ruTSICFo6WrELXJqpR2mRKX_T5wrFPHOI5cm8BZS_JpXg0N3EKLe0u_shNZ1zy2SAf6jJQ4pCPAOhyKsZFRj7mqKkzua5v_Qog6fyPbBXBw7q3lciyxXCF1t7CslbMTrHOb4FIEff7p1hpjd-qy0ya_bmo9pEecQY2iimMT4Dz70QShKNIgaAERE9DE15w12Apn8YKi0uQny7AoMLNkuHbUXRp_N0ViWZI5waZfWA3yo-PRBNCR1U3__xtQgTIGV4FOZKEM-zZsMMpg=w235-h170-no?authuser=0")
                ->setRightPic4Url("https://lh3.googleusercontent.com/M8Q3ZRHP192BCa9MkkiJgbTRqyrxZuJSRruS4mBQHmuPvFr8G0l8Sobqu6hIndEHYeSxprVBZ2Ltd1v4m4JHW09VMGKZVslMzrpJIqqEMk5CR1oJCHMLT7YcOrR5Rt6AWGKRC0ExZ6GoppGBAJJMt7qiWfFO6K736GGKpLqHqcCX3Xj_VFO6YEUyQIm09Tqiv96vEOcwt3IrCf4reumJOsDZj4wehGBci3DUMDsQLCYFVEjc--Ohs_gHd0y_4MezP4Yb_IrnDCzNeq2jgILkSNy-H3WPg532Pg4wXRG2I-gEeVGglLY2yRWU0vEX_QBI_lK4dRK9ADDOwQQeHexUowJuKt3Q1TH7EEjeWN2tUGR8EUB1eR-O9W6HWpLk1ADqfnxPeaNKxBOjp3fcMNebgrOXlgu22fDX3W4m7RyHO7WKuzIDjFzA3TXesyFvpC_9bYFDDZ57UtxwJL5WR-flSDqpbfxRD1ywWdnYnlC7b12LhwZNmSokSSlXgQekUv2-msAmrEa8ha1YQ9A0JH2s6NriHnr1DSLDIi7XIm-l7nXMDpUj0TvFtgASJFm7kS45UFvJq44QNJ77uxCneg6eJ4HDWOQ83aJj2Aqr3KFcaL0a5pwjDTaR1nkm9hPnj9Hp87Jat9NCi3gNbzhth0nsYvClEiTaZQnHjvjC87WAIcltNaAovIwwFBql6guZGA=w235-h170-no?authuser=0")
                ->setRightPic5Url("https://lh3.googleusercontent.com/05Nkv8fz7l-aknz_JQGZ4nO_o-V3eb23q9Q3yaeAN7BD4seUuQq65VvV0y_t3EV9NDQkspzM15kYdavO4VE0xY-9xSPw_2cv_mzMF6V__fBTY3Ku9N22HVEqNIx2quP-jA9FmqE2WJjWqDnuuDZDxmgsfiXOQNbpRV_BXpFPhKwNwy9L5-nAyV_9iqJjTJx80MzmxhbcmgGUp_tjyzd3Nbo0qXVArxixBRJcERHUoHwK0y_h4mif__5CzpOBSpho6_clABajy117I3iA2DQ8qKoGyTSYA6pUzlzr7Z6cLEruIBw8ArDW4mQ5iQJTgB9WHIXwnBQcuKtA3n7g1gPhGxidWIqegyXYppMhKwktIO7S48B4jIZEIHpJE5sxFK0rKqtaEDEM9HzM0ILcqY0revZhbpp48hHMTuZJAtzXE5INXmjW5YfU32ceGNIZ4M7gvVKVAcNJRRCIm52QmzmMR9GHslaY6nlqQiP5siylZf62cXd4hzJ3eVkkeo1hKH7Z0UTQ5ttheHCYgHIVo3G2pLEYCtQ5vZOdlPyHVhKZHTpukQ4-cUZNtuuHfiYPxPMTs3kQhxS5raO8yNE8jkiGeSmRQsYGuB0bxF7AvcLaO6kct0rChnZRFMqCplOWuU9mapEm61f65CVc5Rp8AeEuB7hDD9r0Bwa2nbbJxTREPK-N4WkDIq31GsQbeNDIuQ=w235-h170-no?authuser=0");
            $manager->persist($product);
        $manager->flush();
    }
}

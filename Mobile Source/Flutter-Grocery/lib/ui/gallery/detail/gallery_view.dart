import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/provider/gallery/gallery_provider.dart';
import 'package:fluttermultigrocery/repository/gallery_repository.dart';
import 'package:fluttermultigrocery/ui/common/base/ps_widget_with_appbar_no_app_bar_title.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:fluttermultigrocery/viewobject/default_photo.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:photo_view/photo_view_gallery.dart';
import 'package:provider/provider.dart';

class GalleryView extends StatefulWidget {
  const GalleryView({
    Key key,
    @required this.selectedDefaultImage,
    this.onImageTap,
  }) : super(key: key);

  final DefaultPhoto selectedDefaultImage;
  final Function onImageTap;

  @override
  _GalleryViewState createState() => _GalleryViewState();
}

class _GalleryViewState extends State<GalleryView> {
  @override
  Widget build(BuildContext context) {
    final GalleryRepository galleryRepo =
        Provider.of<GalleryRepository>(context);
    print(
        '............................Build UI Again ............................');
    return PsWidgetWithAppBarNoAppBarTitle<GalleryProvider>(
      initProvider: () {
        return GalleryProvider(repo: galleryRepo);
      },
      onProviderReady: (GalleryProvider provider) {
        provider.loadImageList(
          widget.selectedDefaultImage.imgParentId,
        );
      },
      builder: (BuildContext context, GalleryProvider provider, Widget child) {
        if (provider.galleryList != null &&
            provider.galleryList.data != null &&
            provider.galleryList.data.isNotEmpty) {
          int selectedIndex = 0;
          for (int i = 0; i < provider.galleryList.data.length; i++) {
            if (widget.selectedDefaultImage.imgId ==
                provider.galleryList.data[i].imgId) {
              selectedIndex = i;
              break;
            }
          }

          return Stack(
            children: <Widget>[
              // Positioned(
              //   child: Container(width: 50, height: 50,
              //   child: Icon(Icons.clear,color: PsColors.white))),

              PhotoViewGallery.builder(
                itemCount: provider.galleryList.data.length,
                builder: (BuildContext context, int index) {
                  return PhotoViewGalleryPageOptions.customChild(
                    child: PsNetworkImageWithUrl(
                      photoKey: '',
                      width: MediaQuery.of(context).size.width,
                      height: MediaQuery.of(context).size.height,
                      imagePath: provider.galleryList.data[index].imgPath,
                      onTap: widget.onImageTap,
                      boxfit: BoxFit.contain,
                    ),
                    childSize: MediaQuery.of(context).size,
                  );
                },
                pageController: PageController(initialPage: selectedIndex),
                scrollPhysics: const BouncingScrollPhysics(),
                loadingBuilder: (BuildContext context, ImageChunkEvent event) =>
                    const Center(
                  child: CircularProgressIndicator(),
                ),
              ),
              Positioned(
                  left: PsDimens.space16,
                  top: PsDimens.space72,
                  child: GestureDetector(
                    child: Container(
                        width: 50,
                        height: 50,
                        child: Icon(Icons.clear, color: PsColors.white)),
                    onTap: () {
                      Navigator.pop(context);
                    },
                  )),
            ],
          );
        } else {
          return Container();
        }
      },
    );
  }
}

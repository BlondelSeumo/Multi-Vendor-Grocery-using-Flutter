import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';

class DownloadProduct extends PsObject<DownloadProduct> {
  DownloadProduct(
      {this.imgId,
      this.imgParentId,
      this.imgType,
      this.imgPath,
      this.imgWidth,
      this.imgHeight,
      this.imgDesc});

  String imgId;
  String imgParentId;
  String imgType;
  String imgPath;
  String imgWidth;
  String imgHeight;
  String imgDesc;

  @override
  String getPrimaryKey() {
    return imgId;
  }

  @override
  DownloadProduct fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return DownloadProduct(
          imgId: dynamicData['img_id'],
          imgParentId: dynamicData['img_parent_id'],
          imgType: dynamicData['img_type'],
          imgPath: dynamicData['img_path'],
          imgWidth: dynamicData['img_width'],
          imgHeight: dynamicData['img_height'],
          imgDesc: dynamicData['img_desc']);
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['img_id'] = object.imgId;
      data['img_parent_id'] = object.imgParentId;
      data['img_type'] = object.imgType;
      data['img_path'] = object.imgPath;
      data['img_width'] = object.imgWidth;
      data['img_height'] = object.imgHeight;
      data['img_desc'] = object.imgDesc;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<DownloadProduct> fromMapList(List<dynamic> dynamicDataList) {
    final List<DownloadProduct> downloadProductList = <DownloadProduct>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          downloadProductList.add(fromMap(dynamicData));
        }
      }
    }
    return downloadProductList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<DownloadProduct> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];

    if (objectList != null) {
      for (DownloadProduct data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}

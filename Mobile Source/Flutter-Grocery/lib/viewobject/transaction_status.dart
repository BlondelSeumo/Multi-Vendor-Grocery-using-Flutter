import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';

class TransactionStatus extends PsObject<TransactionStatus> {
  TransactionStatus(
      {this.id, this.title, this.ordering, this.colorValue, this.addedDate});

  String id;
  String title;
  String ordering;
  String colorValue;
  String addedDate;

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  TransactionStatus fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return TransactionStatus(
        id: dynamicData['id'],
        title: dynamicData['title'],
        ordering: dynamicData['ordering'],
        colorValue: dynamicData['color_value'],
        addedDate: dynamicData['added_date'],
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    final Map<String, dynamic> data = <String, dynamic>{};
    if (object != null) {
      data['id'] = object.id;
      data['title'] = object.title;
      data['ordering'] = object.ordering;
      data['color_value'] = object.colorValue;
      data['added_date'] = object.addedDate;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<TransactionStatus> fromMapList(List<dynamic> dynamicDataList) {
    final List<TransactionStatus> defaultPhotoList = <TransactionStatus>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          defaultPhotoList.add(fromMap(dynamicData));
        }
      }
    }
    return defaultPhotoList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<TransactionStatus> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];

    if (objectList != null) {
      for (TransactionStatus data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}

import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';

class RatingDetail extends PsObject<RatingDetail> {
  RatingDetail(
      {this.fiveStarCount,
      this.fiveStarPercent,
      this.fourStarCount,
      this.fourStarPercent,
      this.threeStarCount,
      this.threeStarPercent,
      this.twoStarCount,
      this.twoStarPercent,
      this.oneStarCount,
      this.oneStarPercent,
      this.totalRatingCount,
      this.totalRatingValue});

  String fiveStarCount;
  String fiveStarPercent;
  String fourStarCount;
  String fourStarPercent;
  String threeStarCount;
  String threeStarPercent;
  String twoStarCount;
  String twoStarPercent;
  String oneStarCount;
  String oneStarPercent;
  String totalRatingCount;
  String totalRatingValue;

  @override
  String getPrimaryKey() {
    return '';
  }

  @override
  RatingDetail fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return RatingDetail(
          fiveStarCount: dynamicData['five_star_count'],
          fiveStarPercent: dynamicData['five_star_percent'],
          fourStarCount: dynamicData['four_star_count'],
          fourStarPercent: dynamicData['four_star_percent'],
          threeStarCount: dynamicData['three_star_count'],
          threeStarPercent: dynamicData['three_star_percent'],
          twoStarCount: dynamicData['two_star_count'],
          twoStarPercent: dynamicData['two_star_percent'],
          oneStarCount: dynamicData['one_star_count'],
          oneStarPercent: dynamicData['one_star_percent'],
          totalRatingCount: dynamicData['total_rating_count'],
          totalRatingValue: dynamicData['total_rating_value']);
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['five_star_count'] = object.fiveStarCount;
      data['five_star_percent'] = object.fiveStarPercent;
      data['four_star_count'] = object.fourStarCount;
      data['four_star_percent'] = object.fourStarPercent;
      data['three_star_count'] = object.threeStarCount;
      data['three_star_percent'] = object.threeStarPercent;
      data['two_star_count'] = object.twoStarCount;
      data['two_star_percent'] = object.twoStarPercent;
      data['one_star_count'] = object.oneStarCount;
      data['one_star_percent'] = object.oneStarPercent;
      data['total_rating_count'] = object.totalRatingCount;
      data['total_rating_value'] = object.totalRatingValue;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<RatingDetail> fromMapList(List<dynamic> dynamicDataList) {
    final List<RatingDetail> ratingDetailList = <RatingDetail>[];

    if (dynamicDataList != null) {
      for (dynamic json in dynamicDataList) {
        if (json != null) {
          ratingDetailList.add(fromMap(json));
        }
      }
    }
    return ratingDetailList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<RatingDetail> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (RatingDetail data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}

(function() {
  var creativeDefinition = {
    customScriptUrl: '',
    isDynamic: false,
    delayedImpression: false,
    standardEventIds: {
      DISPLAY_TIMER: '2',
      INTERACTION_TIMER: '3',
      INTERACTIVE_IMPRESSION: '4',
      FULL_SCREEN_VIDEO_PLAYS: '5',
      FULL_SCREEN_VIDEO_COMPLETES: '6',
      FULL_SCREEN_AVERAGE_VIEW_TIME: '7',
      MANUAL_CLOSE: '8',
      BACKUP_IMAGE_IMPRESSION: '9',
      EXPAND_TIMER: '10',
      VIDEO_PLAY: '11',
      VIDEO_VIEW_TIMER: '12',
      VIDEO_COMPLETE: '13',
      VIDEO_INTERACTION: '14',
      VIDEO_PAUSE: '15',
      VIDEO_MUTE: '16',
      VIDEO_REPLAY: '17',
      VIDEO_MIDPOINT: '18',
      FULL_SCREEN_VIDEO: '19',
      VIDEO_STOP: '20',
      VIDEO_FIRST_QUARTILE: '960584',
      VIDEO_THIRD_QUARTILE: '960585',
      VIDEO_UNMUTE: '149645',
      FULL_SCREEN: '286263',
      DYNAMIC_CREATIVE_IMPRESSION: '536393',
      HTML5_CREATIVE_IMPRESSION: '871060'
    },
    exitEvents: [
      {
        name: 'Background_ClickThrough',
        reportingId: '1856816',
        url: 'http://www.chevrolet.com.mx/spark.html?cmp\x3dnuevo:chevrolet_spark2015_esmas_300x250',
        targetWindow: '_blank',
        windowProperties: ''
      }
    ],
    timerEvents: [
      {
        name: 'expanded Expansion',
        reportingId: '1850898',
        videoData: null
      }
    ],
    counterEvents: [
    ],
    childFiles: [
      {
        name: 'SparkFase1_Esmas_BoxBannerExp_300x500_expandido.swf',
        url: '/ads/richmedia/studio/pv2/33339542/20140825111619670/SparkFase1_Esmas_BoxBannerExp_300x500_expandido.swf',
        isVideo: false
      },
      {
        name: 'SparkFase1_Esmas_BoxBannerExp_300x250_contraido.swf',
        url: '/ads/richmedia/studio/pv2/33339542/20140825111619670/SparkFase1_Esmas_BoxBannerExp_300x250_contraido.swf',
        isVideo: false
      },
      {
        name: 'SparkFase1_Esmas_BoxBannerExp_300x250_parent.jpg',
        url: '/ads/richmedia/studio/pv2/33339542/20140825111619670/SparkFase1_Esmas_BoxBannerExp_300x250_parent.jpg',
        isVideo: false
      }
    ],
    videoFiles: [
    ],
    videoEntries: [
    ],
    primaryAssets: [
      {
        id: '33340607',
        artworkType: 'FLASH',
        displayType: 'EXPANDABLE',
        width: '300',
        height: '500',
        servingPath: '/ads/richmedia/studio/pv2/33339542/20140825111619670/SparkFase1_Esmas_BoxBannerExp_300x250_parent.swf',
        zIndex: '1000000',
        customCss: '',
        flashArtworkTypeData: {
          actionscriptVersion: '3',
          wmode: 'transparent',
          sdkVersion: '2.3.1'
        },
        htmlArtworkTypeData: null,
        floatingDisplayTypeData: null,
        expandingDisplayTypeData: {
          collapsedRect: {
            left: 0,
            top: 0,
            width: 300,
            height: 250
          },
          isPushdown: false,
          pushdownAnimationTime: 0,
          expansionMode: 'NORMAL'
        },
        imageGalleryTypeData: null,
        pageSettings:{
          hideDropdowns: false,
          hideIframes: false,
          hideObjects: false,
          updateZIndex: true
        },
layoutsConfig: null,
layoutsApi: null
      }
    ]
  }
  var rendererDisplayType = '';
  rendererDisplayType += 'flash_';
  var rendererFormat = 'expanding';
  var rendererName = rendererDisplayType + rendererFormat;

  var creativeId = '59200370';
  var adId = '284182702';
  var templateVersion = '200_48';
  var studioObjects = window['studioV2'] = window['studioV2'] || {};
  var creativeObjects = studioObjects['creatives'] = studioObjects['creatives'] || {};
  var creativeKey = [creativeId, adId].join('_');
  var creative = creativeObjects[creativeKey] = creativeObjects[creativeKey] || {};
  creative['creativeDefinition'] = creativeDefinition;
  var adResponses = creative['adResponses'] || [];
  for (var i = 0; i < adResponses.length; i++) {
    adResponses[i].creativeDto && adResponses[i].creativeDto.csiEvents &&
        (adResponses[i].creativeDto.csiEvents['pe'] =
            adResponses[i].creativeDto.csiEvents['pe'] || (+new Date));
  }
  var loadedLibraries = studioObjects['loadedLibraries'] = studioObjects['loadedLibraries'] || {};
  var versionedLibrary = loadedLibraries[templateVersion] = loadedLibraries[templateVersion] || {};
  var typedLibrary = versionedLibrary[rendererName] = versionedLibrary[rendererName] || {};
  if (typedLibrary['bootstrap']) {
    typedLibrary.bootstrap();
  }
})();

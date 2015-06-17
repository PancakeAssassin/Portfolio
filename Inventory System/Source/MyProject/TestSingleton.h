// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "Object.h"
#include "TestSingleton.generated.h"


USTRUCT(BlueprintType)
struct FItemTable : public FTableRowBase
{
	GENERATED_USTRUCT_BODY()

public:

	FItemTable()
	: ItemName("Default Name"),
	  Description("Blah blah blah"),
	  Value(0)
	{}

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category="GameItem")
	FString ItemName;

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category= "GameItem")
	FString Description;

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category= "GameItem")
	int32 Value;

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category= "GameItem")
	TAssetPtr<UMaterial> TextureResource;

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category= "GameItem")
	TAssetPtr<UStaticMesh> MeshResource;
};

/**
 * 
 */
UCLASS(Config= Game, notplaceable)
class MYPROJECT_API UTestSingleton : public UObject, public FTickerObjectBase
{
	GENERATED_UCLASS_BODY()

private:
	UTestSingleton();

public:
	static UTestSingleton& Get();
	FStreamableManager AssetLoader;

	UDataTable* ItemTable;

	virtual bool Tick(float DeltaSeconds) override;
};
